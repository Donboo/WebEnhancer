<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Dashboard
* 
* 
* @package    T4P
* @subpackage Controller
*/

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model'); 
        $this->load->helper(array('url'));
        $this->load->library(array('pagination'));
        
        if($this->session->userdata('logged_in') == null) {
            redirect(base_url("login"));
        }
        
        if (!is_cache_valid(md5('dashboard'), 60)){
            $this->db->cache_delete('dashboard');
        }
    }
 
    public function index()
    {
        
        // TRANSLATE
        $data['text_projects']              = $this->lang->line('dashboard_projects');
        $data['text_add_project']           = $this->lang->line('dashboard_add_project');
        $data['text_settings']              = $this->lang->line('dashboard_settings');
        $data['text_signout']               = $this->lang->line('dashboard_signout');
        $data['text_logins']                = $this->lang->line('dashboard_logins');
        $data['text_news']                  = $this->lang->line('dashboard_news');
        
        $data['news']                       = $this->Dashboard_model->get_news();
        
        $data["main_content"] = 'dashboard/dashboard_view';
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
 
    public function recover() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email',      'Email',    'trim|required|valid_email|xss_clean');
        
        $data["main_content"] = 'login/recover_view';
        $this->load->view('includes/template.php', $data);
    }
    
    public function settings() {
        $data["text_manage_your_settings"]  = $this->lang->line('dashboard_manage_settings');   
        $data['text_update_password']       = $this->lang->line('dashboard_update_password');
        $data['text_change_picture']        = $this->lang->line('dashboard_change_picture');
        $data['text_invalid_login']         = $this->lang->line('dashboard_invalid_login');
        $data['text_update_email']          = $this->lang->line('dashboard_update_email');
        $data['text_add_project']           = $this->lang->line('dashboard_add_project');
        $data['text_projects']              = $this->lang->line('dashboard_projects');
        $data['text_settings']              = $this->lang->line('dashboard_settings');
        $data['text_signout']               = $this->lang->line('dashboard_signout');
        $data['text_logins']                = $this->lang->line('dashboard_logins');
        $data['text_news']                  = $this->lang->line('dashboard_news');

        if(strlen($this->session->userdata('logged_in')["PhotoName"]) > 32) {
            $data['avatar_name']                = $this->session->userdata('logged_in')["PhotoName"];
        } else $data['avatar_name']             = "default.png";
         
        $data["main_content"]   = 'dashboard/settings_view';
        $this->load->view('includes/template.php', $data);
    }
    
    public function projects() {
        
        // TRANSLATE
        $data["text_project_name"]          = $this->lang->line('dashboard_project_name');
        $data["text_first_scan"]            = $this->lang->line('dashboard_first_scan');
        $data["text_last_scan"]             = $this->lang->line('dashboard_last_scan');
        $data["text_manage_your_projects"]  = $this->lang->line('dashboard_manage_projects');
        $data['text_first_result']          = $this->lang->line('dashboard_first_result');
        $data['text_last_result']           = $this->lang->line('dashboard_last_result');
        $data['text_view_project']          = $this->lang->line('dashboard_view_project');
        $data['text_projects']              = $this->lang->line('dashboard_projects');
        $data['text_add_project']           = $this->lang->line('dashboard_add_project');
        $data['text_settings']              = $this->lang->line('dashboard_settings');
        $data['text_signout']               = $this->lang->line('dashboard_signout');
        $data['text_logins']                = $this->lang->line('dashboard_logins');
        $data['text_news']                  = $this->lang->line('dashboard_news');
        
        // DATA
        $data["project"]                    = $this->Dashboard_model->get_projects($this->session->userdata('logged_in')["ID"]);
        
        $data["main_content"]   = 'dashboard/projects_view';
        $this->load->view('includes/template.php', $data);
    }
    
    public function addproject() {
        
        // TRANSLATE
        $data["main_content"]   = 'dashboard/add_project';
        $this->load->view('includes/template.php', $data);
    }
    
    public function uploadpicture() {
        $data["text_manage_your_settings"]  = $this->lang->line('dashboard_manage_settings');   
        $data['text_update_password']       = $this->lang->line('dashboard_update_password');
        $data['text_change_picture']        = $this->lang->line('dashboard_change_picture');
        $data['text_invalid_login']         = $this->lang->line('dashboard_invalid_login');
        $data['text_update_email']          = $this->lang->line('dashboard_update_email');
        $data['text_add_project']           = $this->lang->line('dashboard_add_project');
        $data['text_projects']              = $this->lang->line('dashboard_projects');
        $data['text_settings']              = $this->lang->line('dashboard_settings');
        $data['text_signout']               = $this->lang->line('dashboard_signout');
        $data['text_logins']                = $this->lang->line('dashboard_logins');
        $data['text_news']                  = $this->lang->line('dashboard_news');

        if(strlen($this->session->userdata('logged_in')["PhotoName"]) > 32) {
            $data['avatar_name']                = $this->session->userdata('logged_in')["PhotoName"];
        } else $data['avatar_name']             = "default.png";
        
        $config['upload_path']              = realpath(FCPATH.'assets/images/users/');
        $config['encrypt_name']             = TRUE;
        $config['allowed_types']            = 'gif|jpg|jpeg|png';
        $config['max_size']                 = 1000;//kb
        $config['max_width']                = 0;
        $config['max_height']               = 0;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('fileinputed'))
        {
            $data["upload_message"]         = array('error' => $this->upload->display_errors());

            $data["main_content"]           = 'dashboard/settings_view';
            $this->load->view('includes/template.php', $data);        
        }
        else
        {
            $this->Dashboard_model->update_user_photo($this->session->userdata('logged_in')["ID"], $this->upload->data("file_name"));
            $data["text_uploaded"]          = $this->lang->line('dashboard_uploaded');

            $data["main_content"]           = 'dashboard/settings_view';
            $this->load->view('includes/template.php', $data);
        }
    }
    
    public function logins() {
        // TRANSLATE
        $data["text_manage_your_logins"]    = $this->lang->line('dashboard_manage_logins');
        $data['text_invalid_login']         = $this->lang->line('dashboard_invalid_login');
        $data['text_add_project']           = $this->lang->line('dashboard_add_project');
        $data['text_projects']              = $this->lang->line('dashboard_projects');
        $data['text_settings']              = $this->lang->line('dashboard_settings');
        $data['text_signout']               = $this->lang->line('dashboard_signout');
        $data['text_logins']                = $this->lang->line('dashboard_logins');
        $data['text_news']                  = $this->lang->line('dashboard_news');
        
        $params = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Dashboard_model->get_total_logins($this->session->userdata('logged_in')["ID"]);
 
        if ($total_records > 0) 
        {
            // get current page records
            $data["logins"]                 = $this->Dashboard_model->get_logins($this->session->userdata('logged_in')["ID"], $limit_per_page);
            
            $config['base_url']             = base_url() . 'dashboard/logins/';
            $config['total_rows']           = $total_records;
            $config['per_page']             = $limit_per_page;
            $config['uri_segment']          = 3;

            
            $config['full_tag_open']        = '<br><nav class="pagination is-centered" role="navigation" aria-label="pagination"><ul class="pagination-list">';
            $config['full_tag_close']       = '</ul></nav>';

            $config['first_link']           = 'First Page';
            $config['first_tag_open']       = '<li>';
            $config['first_tag_close']      = '</li>';

            $config['last_link']            = 'Last Page';
            $config['last_tag_open']        = '<li>';
            $config['last_tag_close']       = '</li>';

            $config['next_link']            = 'Next';
            $config['next_tag_open']        = '';
            $config['next_tag_close']       = '';

            $config['prev_link']            = 'Previous';
            $config['prev_tag_open']        = '';
            $config['prev_tag_close']       = '';
            
            $config['attributes'] = array('class' => 'pagination-link');

            $config['cur_tag_open'] = '<li><a class="pagination-link is-current" aria-current="page">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
             
            $this->pagination->initialize($config);
            
            $data['links'] = $this->pagination->create_links();
        } else $data["logins"]  = false;
        
        $data["main_content"]   = 'dashboard/logins_view';
        $this->load->view('includes/template.php', $data);
    }
    
        
    public function logout() {
        $this->session->sess_destroy();
        flash_redirect('success', 'You have signed out.', base_url());
    }
}
?>