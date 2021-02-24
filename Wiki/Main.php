<?php
namespace Wiki;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
use Wiki\Load;
class Main
{
    private $config;
    private $load;
    public $menuData = array();
    public $docData = array();
    const DOC_PATH = 'Wiki/docs/';
    
    public function __construct()
    {
        $this->config = require_once 'Wiki/config.php';
        $this->load = new Load();
        if ($this->config['use_database']) {
            require_once 'Wiki/idiorm/idiorm.php';
            require_once 'Wiki/paris/paris.php';
            require_once 'Wiki/Doc.php';
            \ORM::configure($this->config['db_host']);
            \ORM::configure('username', $this->config['db_username']);
            \ORM::configure('password', $this->config['db_password']);
            //ORM::configure('return_result_sets', true);
            //$categories = \ORM::for_table('documents')->select('id')->select('title')->distinct()->select('category')->find_array();
            //$this->menuData = $this->getMenuData($categories);
        }
        //$this->menuData = $this->getMenuData($this->getFileBasedDocs());
        $this->getDocs();
        $this->getMenuData();
    }
    

    /**
     * used to load a pre built example 
     */
    public function index()
    {
        $viewParams = [
            'title' => $this->config['site_name'],
            'cssFiles' => $this->config['css'],
            'jsFiles' => $this->config['js'],
        ];

        // loads html boilerplate with Css and Js from config
        $this->load->view(
            'Wiki/templates/header.php',
            $viewParams,
            false
        );


        // loads the main wiki page uses css and js loaded previously
        $this->load->view(
            'Wiki/templates/body.php',
            [
                'menuData' => $this->menuData,
                'containerClass' => 'container',
                'innerContainerClass' => 'row justify-content-between',
                'navClass' => 'nav flex-column nav-vertical',
                'searchFormClass' => 'd-flex',
                'searchInputClass' => 'form-control me-2',
                'searchButtonClass' => 'btn btn-outline-success',
                'navListClass' => 'pt-4 nav flex-column nav-colapse',
                'navListItemClass' => 'nav-item',
                'navLinkClass' => 'nav-link',
                'contentClass' => 'col-sm-8 col-lg-10',
                // load inner content
                'content' => $this->load->view(
                    'Wiki/templates/default.php',
                    [],
                    true
                ),
            ],
            false
        );
        /**
         *  [
         *      'sections' => $sections,
         *      'secTitleClass' => 'text-center',
         *      'secParagraphClass' => 'ps-5',
         *      'secHeaderClass' => ''
         *  ]
         */
        // loads the footer boilerplate to close the html and body tags
        $this->load->view(
            'Wiki/templates/footer.php',
            [],
            false
        );
    }

    private function getDocs()
    {
        if ($this->config['use_database']) {
            $this->getDbBasedDocs();
        } else {
            $this->getFileBasedDocs();
        }
    }

    private function getMenuData()
    {
        if ($this->config['use_database']) {
            $docData = \ORM::for_table('documents')->select('id')->select('title')->distinct()->select('category')->find_array();
        } else {
            $docData = $this->docData;
        }
        
        foreach ($docData as $doc) {
            $this->menuData[$doc['category']][] = $doc;
        }
        
    }

    public function getDoc($document)
    {
        return $this->load->view(
            'Wiki/templates/content.php',
            [
                'sections' => [$this->docData[$document]],
                'secTitleClass' => 'text-center',
                'secParagraphClass' => 'ps-5',
                'secHeaderClass' => ''
            ],
            true
        );
    }

    private function getFileBasedDocs(){
        if (empty($this->docData)) {
            $docFiles = scandir(self::DOC_PATH);
            unset($docFiles[0]);
            unset($docFiles[1]);
            $docFiles = array_values($docFiles);
            foreach ($docFiles as $file) {
                $data = include self::DOC_PATH . $file;
                $this->docData[$data['id']] = $data;
            }
        }
    }

    private function getDbBasedDocs(){
        foreach (\Model::factory('Doc')->find_array() as $doc) {
            $doc['content'] = json_decode($doc['content'], true);
            foreach ($doc['content'] as $key => $section) {
                $doc['content'][$key]['sub_content'] = base64_decode($section['sub_content']);
            }
            $this->docData[$doc['id']] = $doc;
        }
    }
}

