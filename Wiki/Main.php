<?php
namespace Wiki;
use \Wiki\Load;

class Main
{
    private $config;
    private $load;
    const DOC_PATH = 'docs/';

    public function __construct()
    {
        $this->config = include_once './config.php';
        $this->load = new Load;
        
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
            'templates/header.php',
            $viewParams,
            false
        );


        // loads the main wiki page uses css and js loaded previously
        $this->load->view(
            'templates/body.php',
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
                    'templates/default.php',
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
            'templates/footer.php',
            [],
            false
        );
    }

    private function getDocs()
    {
        $docFiles = scandir('docs');
        unset($docFiles[0]);
        unset($docFiles[1]);
        $docFiles = array_values($docFiles);
        
        $docs = array();
        foreach ($docFiles as $file) {
            $data = include_once self::DOC_PATH . $file;
            $docs[$data['id']] = $data;
        }

        if(!empty($docs)){
            return $docs;
        }

        return array();
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
            'templates/content.php',
            [
                'sections' => [$sections[$document]],
                'secTitleClass' => 'text-center',
                'secParagraphClass' => 'ps-5',
                'secHeaderClass' => ''
            ],
            true
        );
    }
}

