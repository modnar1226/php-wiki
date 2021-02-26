<?php
namespace Wiki;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
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
        }
        $this->getMenuData();
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
            $this->getDocs();
            $docData = $this->docData;
        }
        
        foreach ($docData as $doc) {
            $this->menuData[$doc['category']][] = $doc;
        }
        
    }

    public function getDoc($document)
    {
        $this->getDocs();
        return $this->docData[$document];
        
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

