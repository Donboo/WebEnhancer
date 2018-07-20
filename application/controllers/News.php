<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* News
* 
* 
* @package    WebEnhancer
* @subpackage Controller
*/

class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model'); 
        $this->load->helper(array('url'));
    }
 
    public function index()
    {
        if($this->uri->segment(2) == null || !exists($this->uri->segment(2), "news")) {
            $this->session->set_flashdata('error', 'Invalid news.');
            redirect(base_url());
        }
        
        $data["image"]          = get_cached_info("Image", "news", "ID", $this->uri->segment(2));
        $data["title"]          = substr(get_cached_info("Content", "news", "ID", $this->uri->segment(2)), 0, 20);
        $data["content"]        = get_cached_info("Content", "news", "ID", $this->uri->segment(2));
        
        $data["main_content"] = 'news_view';
        $this->load->view('includes/template.php', $data);
    }
    
    public function _remap($method,$args)
    {
        if (method_exists($this, $method))
        {
            $this->$method($args);  
        }
        else
        {
            $this->index($method,$args);
        }
    }
 
}
?>