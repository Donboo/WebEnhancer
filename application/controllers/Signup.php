<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Signup
* 
* 
* @package    WebEnhancer
* @subpackage Controller
*/

class Signup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model'); 
        $this->load->helper(array('url'));
        $this->load->library('user_agent');
        
        if($this->session->userdata('logged_in') !== null) {
            flash_redirect('error', 'Nu poti accesa niciuna dintre urmatoarele pagini daca esti logat: autentificare, recuperare parola, inregistrare.', base_url());
        }
    }
 
    public function index()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
        $this->form_validation->set_error_delimiters('<div class="notification is-danger"><button class="delete"></button>', '</div>');

        if($this->form_validation->run() == FALSE)
        {
            $data["logintitle"]                 = $this->lang->line("login_signuptitle");
            $data["text_alternativebottom"]     = $this->lang->line("signup_alternativebottom");
            
            $data["main_content"]               = 'login/signup_view';
            $this->load->view('includes/template.php', $data);
        }
        else
        {
            $email      = $this->input->post('email');
            $password   = $this->input->post('password');
            
            if(strlen($email) && strlen($password)) {
                if(!exists($email, $this->config->config['tables']['accounts'], "EMail")) {
                    $salt               = bin2hex(openssl_random_pseudo_bytes(10));
                    $encoded_password   = hash("sha256",  "mOGhbVyt!4JkL" . implode($salt, str_split($password, floor(strlen($password)/2))) . $salt);
                    
                    if($this->Login_model->insert_user($email, $encoded_password, $salt, $this->input->ip_address())) {
                        $this->load->library('email');

                        $this->email->from('mailer@webenhancer.com', 'WebEnhancer');
                        $this->email->to($email);

                        $this->email->subject('\xF0\x9F\x94\xA5 Confirm your registration to WebEnhancer');
                        $this->email->message('Hello!<br>Your email address <b>' . $email . '</b> was used to register an account to <a href="' . base_url() . '">WebEnhancer - Free website enhancer</a>.<br><br>In order to confirm your registration, please follow the next link: /LINK/.<br><br>If you haven\'t requested this registration, please ignore this email.<br><br><br>With pleasure,<br>WebEnhancer team.');

                        $this->email->send();
                        flash_redirect('success', 'Your account has been registered', base_url("login"));
                    } else flash_redirect('error', 'Something went wrong.', base_url("signup"));
                } else {
                    flash_redirect('error', 'The account you\'re trying to register is already registered. Pick another email address', base_url("signup"));
                }
            } else {
                flash_redirect('error', 'Datele introduse sunt invalide.', base_url("signup"));
            }
        }
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
    
   public function checkPassword($pwd) {

        if (strlen($pwd) < 8) {
            $error = "Parola trebuie sa contina minim 8 caractere";
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $error .= "<br>Parola trebuie sa includa cel putin un numar";
        }

        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            $error .= "<br>Parola trebuie sa contina cel putin o litera";
        }     

        if(isset($error)) return $error; else return 5;
    }
    
}
?>