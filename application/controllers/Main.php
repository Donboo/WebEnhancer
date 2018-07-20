<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Main
* 
* 
* @package    WebEnhancer
* @subpackage Controller
*/

class Main extends CI_Controller {
    
    public function __construct() 
    {       
        parent:: __construct();
        $this->load->model('Main_model'); 
        $this->load->helper('htmlpurifier');
    }
    
    public function index()
    {
        $data['title']                      = $this->lang->line('main_title');
        $data['subtitle']                   = $this->lang->line('main_subtitle');
        
        $data['firstargument']              = $this->lang->line('main_firstargument');
        $data['firstargumentsubtitle']      = $this->lang->line('main_firstargumentsubtitle');
        
        $data['speedtests']                 = $this->lang->line('main_speedtests');
        $data['speedtestsargument']         = $this->lang->line('main_speedtestsargument');
        
        $data['codevalidator']              = $this->lang->line('main_codevalidator');
        $data['codevalidatorargument']      = $this->lang->line('main_codevalidatorargument');
        
        $data['seohelper']                  = $this->lang->line('main_seohelper');
        $data['seohelperargument']          = $this->lang->line('main_seohelperargument');
        
        $data['testyoursite']               = $this->lang->line('main_testyoursite');
        
        $data['securityaudit']              = $this->lang->line('main_securityaudit');
        $data['securityauditargument']      = $this->lang->line('main_securityauditargument');
        
        $data['lastnews']                   = substr($this->Main_model->get_last_news()[0]["Content"], 0, 20) . "...";
        
        $data['login']                      = $this->lang->line('main_login');
        $data['home']                       = $this->lang->line('main_home');
        $data['about']                      = $this->lang->line('main_about');
        $data['enhanceyourwebsite']         = $this->lang->line('main_enhanceyourwebsite');
        
        if (!is_cache_valid(md5('default'), 300)){
            $this->db->cache_delete('default');
        }
        
        $data["main_content"] = 'main_view';
        $this->load->view('includes/template.php', $data);
    }
    
    function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('', 'refresh');
    }
}
