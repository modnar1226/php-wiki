<?php
namespace Wiki;

class Load
{
    /**
     * @param String $filename : The path to the view file to load.
     * @param Array $vars : The vars to pass to the view, array keys become variables.
     * @param Boolean $returnString : Whether or not to return a string of the view or to echo it immediately.
     * @return String $inlcude : The view file that was loaded
     */
    public function view($filename, $vars = array(), $returnString = false)
    {
        if (!empty($vars)) {
            extract($vars);
        }
        ob_start();
        include $filename;
        $include = ob_get_contents();
        ob_end_clean();

        if ($returnString) {
            return $include;
        }
        echo $include;
    }
}
/* usage
    include 'view.php';
    $load = new Load;
    $load->view('application.php');

    include 'view.php';
    $load = new Load;
    $view = $load->view('application.php',[],false);
*/