<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
use Load;
class Main
{
    private $config;
    private $load;
    const DOC_PATH = 'Wiki/docs/';
    
    public function __construct()
    {
        $this->config = require_once 'Wiki/config.php';
        $this->load = new Load();
        if ($this->config['use_database']) {
            require_once 'Wiki/idiorm-master/idiorm.php';
            require_once 'Wiki/paris-master/paris.php';
            require_once 'Wiki/Doc.php';
            ORM::configure('mysql:host=localhost;dbname=documents');
            ORM::configure('username', 'app');
            ORM::configure('password', 'BamBoozale');
        }
    }
    

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
                'menuData' => $this->getMenuData($this->getDocs()),
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
        $docs = array();
        if ($this->config['use_database']) {
            $docs = $this->getDbBasedDocs();
        } else {
            $docs = $this->getFileBasedDocs();
        }

        // TODO: Add config check for doc type "file vs DB"
        return $docs;
    }

    private function getMenuData($docData)
    {
        $menuData = array();
        foreach ($docData as $doc) {
            $menuData[$doc['category']][] = $doc;
        }

        return $menuData;
    }

    public function getDoc($document)
    {
        $sections = $this->getDocs();
        return $this->load->view(
            'Wiki/templates/content.php',
            [
                'sections' => [$sections[$document]],
                'secTitleClass' => 'text-center',
                'secParagraphClass' => 'ps-5',
                'secHeaderClass' => ''
            ],
            true
        );
    }

    private function getFileBasedDocs(){
        $docFiles = scandir(self::DOC_PATH);
        unset($docFiles[0]);
        unset($docFiles[1]);
        $docFiles = array_values($docFiles);

        $docs = array();
        foreach ($docFiles as $file) {
            $data = include_once self::DOC_PATH . $file;
            $docs[$data['id']] = $data;
        }

        if (!empty($docs)) {
            return $docs;
        }

        return array();
    }

    private function getDbBasedDocs(){
        $docs = array();
        foreach (Model::factory('Doc')->find_array() as $doc) {
            $doc['content'] = json_decode($doc['content'], true);
            foreach ($doc['content'] as $key => $section) {
                $doc['content'][$key]['sub_content'] = base64_decode($section['sub_content']);
            }
            $docs[$doc['id']] = $doc;
        }
        return $docs;
    }
}

