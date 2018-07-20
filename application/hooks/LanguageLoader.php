<?php

/**
* Language Loader
* 
* 
* @package    WebEnhancer
* @subpackage Hooks
*/

class LanguageLoader
{
 
   function initialize() {
       $ci =& get_instance();
       $ci->load->helper('language');
 
       $siteLang = $ci->session->userdata('language');
       if ($siteLang) $ci->lang->load('main', $siteLang); else $ci->lang->load('main', 'english');
   }
}