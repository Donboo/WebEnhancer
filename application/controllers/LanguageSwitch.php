<?php 

if(!defined('BASEPATH')) exit('No direct access allowed');
 
/**
* Language switch
* 
* 
* @package    WebEnhancer
* @subpackage Controller
*/

class LanguageSwitch extends CI_Controller
{

    public function __construct() {
        parent::__construct();
    }

    function switch_language() {
        
        $language = $this->uri->segment(3);
        
        // Get language otherwise set
        $language = ($language != "") ? $language : "english";

        // Verify if language exists
        if(!in_array($language, array("english", "romanian"))) {
            flash_redirect("error", "Inexistent language.", $_SERVER['HTTP_REFERER']);
        }

        $this->session->set_userdata('language', $language);
        redirect($_SERVER['HTTP_REFERER']);
    }

}