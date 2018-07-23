<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Login
* 
* 
* @package    WebEnhancer
* @subpackage Controller
*/

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); 
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
            $data["logintitle"]                 = $this->lang->line("login_logintitle");
            $data["text_alternativebottom"]     = $this->lang->line("login_alternativebottom");
            $data["main_content"]               = 'login/login_view';
            $this->load->view('includes/template.php', $data);
        }
        else
        {
            if($this->input->post('g-recaptcha-response') !== null) {
                $response = $_POST['g-recaptcha-response'];     
                $remoteIp = $this->input->ip_address();


                $reCaptchaValidationUrl = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$this->config->item('recaptcha_secret')."&response=$response&remoteip=$remoteIp");
                $result = json_decode($reCaptchaValidationUrl, TRUE);

                if($result['success'] == 1) {
                    
                    $email      = $this->input->post('email');
                    $password   = $this->input->post('password');

                    if(strlen($email) && strlen($password)) {

                        $result = $this->User_model->return_user($email, $password);

                        if($result)
                        {
                            $sess_array = array(
                                "ID"        => $result->ID,
                                "EMail"     => $result->EMail,
                                "Role"      => $result->Role,
                                "PhotoName" => $result->PhotoName
                            );
                            $this->session->set_userdata("logged_in", $sess_array);

                            $this->User_model->insert_login($this->session->userdata("logged_in")["ID"], $this->input->ip_address());

                            redirect(base_url("dashboard"));
                        }
                        else flash_redirect('error', 'Datele introduse sunt invalide.', base_url("login"));
                    } else flash_redirect('error', 'Datele introduse sunt invalide.', base_url("login"));
                } else flash_redirect('error', 'recaptcha invalid.', base_url("login"));
            } else flash_redirect('error', 'recaptcha invalid.', base_url("login"));
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
 
    public function recover() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email',   'email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email',      'Email',    'trim|required|valid_email|xss_clean');
        
        $data["main_content"] = 'login/recover_view';
        $this->load->view('includes/template.php', $data);
    }
    
    public function recoverpassw() {
        
        $email   = $this->input->post('email');
        $email      = $this->input->post('email');
        
        if(getUserData($email, "ID") > 0 && strlen($email) > 3 && strlen(getUserData($email, "Email")) > 3) {
            if(getUserData($email, "Email") != "email@yahoo.com") {

                $first = md5(uniqid());
                $final_key = $first . md5($first);

                $this->User_model->recoverPassword(getUserData($email, "ID"), $final_key);

                $msg = $email . "";

                $this->load->library('email', $this->config->item('smtp_array'));
                $this->email->from('mailer@webenhancer.com', 'WebEnhancer');
                $this->email->to('mail');
                $this->email->subject("PASSWORD RECOVERY - WEBENHANCER");
                $this->email->message($msg);
                $this->email->send();

                $email1 = explode('@', $email);				
                $first_part = $email1[0];					
                $domain = $email1[1];
                $newemail = substr($first_part, 0, 4) . "****@" . substr($domain, 0, 10);
                $this->session->set_flashdata('success', 'Codul de verificare a fost trimis catre ' . $newemail . '. Verifica inclusiv folderul SPAM.');
                redirect(base_url("login/recover"));
            } else {
                $this->session->set_flashdata('error', 'Acest cont nu are o adresa de email setata.');
                redirect(base_url("login/recover"));
            }
        } else {
            $this->session->set_flashdata('error', 'Cont invalid sau adresa invalida.');
            redirect(base_url("login/recover"));
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
    
    public function recoverchange() {
        $recoverKey = $this->uri->segment(3);
        
        if($this->User_model->isValidRecovery($recoverKey)) {
            $data["main_content"] = 'login/change_view';
            $this->load->view('includes/template.php', $data);      
        } else {
            $this->session->set_flashdata('error', 'Cheie invalida.');
            redirect(base_url("login/recover"));
        }
    }
    
    public function changepassw() {
        $recoverKey                 = $this->uri->segment(3);
        $confirmationPassword       = $this->input->post('confirmpassword');
        $initialPassword            = $this->input->post('password');
        
        if($this->checkPassword($initialPassword) == 5)
        {
            if($confirmationPassword == $initialPassword) {
                $this->User_model->updateUser($recoverKey, $initialPassword);

                $this->session->set_flashdata('succes', 'Ti-ai resetat parola cu succes.');
                redirect(base_url("login"));
            } else {
                $this->session->set_flashdata('error', 'Parola nu este aceeasi in ambele campuri.');
                redirect(base_url("login/recoverchange/$recoverKey"));
            }
        } else {
            $this->session->set_flashdata('error',  $this->checkPassword($initialPassword));
            redirect(base_url("login/recoverchange/$recoverKey"));
        }
    }
    
}
?>