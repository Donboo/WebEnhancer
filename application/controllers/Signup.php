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
        $this->load->model('User_model'); 
        $this->load->model('User_model'); 
        $this->load->helper(array('url'));
        $this->load->library('user_agent');
        
        if($this->session->userdata('logged_in') !== null) {
            flash_redirect('error', 'Nu poti accesa niciuna dintre urmatoarele pagini daca esti logat: autentificare, recuperare parola, inregistrare.', base_url());
        }
    }
    
    public function confirmregistration() {
        $generated_hash = $this->uri->segment(3);
        
        if(strlen($generated_hash) != 84) flash_redirect('error', 'Invalid hash.', base_url("signup"));
        
        $register_id    = get_info("ID", $this->config->config['tables']['registrations'], "HashGenerated", $generated_hash);
        if($register_id != $generated_hash) flash_redirect('error', 'Invalid hash.', base_url("signup"));
        
        $register_time  = get_info("Timestamp", $this->config->config['tables']['registrations'], "ID", $register_id);
        if(time() - $register_time >= 1800) flash_redirect('error', 'Hash expired.', base_url("signup"));
    
        $this->User_model->confirm_register($given_id);
        flash_redirect('success', 'Congratulations! You can use your account now.', base_url('login'));
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
                    
                    if($this->input->post('g-recaptcha-response') !== null) {
                        $response = $_POST['g-recaptcha-response'];     
                        $remoteIp = $this->input->ip_address();


                        $reCaptchaValidationUrl = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$this->config->item('recaptcha_secret')."&response=$response&remoteip=$remoteIp");
                        $result = json_decode($reCaptchaValidationUrl, TRUE);

                        if($result['success'] == 1) {

                            $salt               = bin2hex(openssl_random_pseudo_bytes(10));
                            $encoded_password   = hash("sha256",  "mOGhbVyt!4JkL" . implode($salt, str_split($password, floor(strlen($password)/2))) . $salt);
                            $generated_hash     = bin2hex(openssl_random_pseudo_bytes(10) . md5($encoded_password . $salt));

                            if($this->User_model->insert_user($email, $encoded_password, $salt, $this->input->ip_address(), $generated_hash)) {

                                $this->load->library('email');

                                $config['protocol']     = 'smtp';
                                $config['smtp_host']    = 'ssl://smtp.gmail.com';
                                $config['smtp_port']    = '465';
                                $config['smtp_timeout'] = '7';
                                $config['smtp_user']    = '';
                                $config['smtp_pass']    = '';
                                $config['charset']      = 'utf-8';
                                $config['newline']      = "\r\n";
                                $config['mailtype']     = 'html';
                                $config['validation']   = TRUE;  

                                $this->email->initialize($config);

                                $this->email->from('mailer@webenhancer.com', 'WebEnhancer');
                                $this->email->to($email);

                                $this->email->subject('\xF0\x9F\x94\xA5 Confirm your registration to WebEnhancer');


                                $message_to_show = ($this->session->userdata('language') == "english") ? 'Hello!<br>Your email address <b>' . $email . '</b> was used to register an account to <a href="' . base_url() . '">WebEnhancer - Free website enhancer</a>.<br><br>In order to confirm your registration, please follow the next link: <a href="' . base_url("signup/confirmregistration/" . $generated_hash) . '">' . base_url("signup/confirmregistration/" . $generated_hash) . '</a>.<b>BE AWARE! This link is valid for only 30 minutes.</b><br><br>If you haven\'t requested this registration, please ignore this email.<br><br><br>Best regards,<br>WebEnhancer team.' : 'Salut!<br>Adresa ta de email: <b>' . $email . '</b> a fost folosită la înregistrarea unui cont pe <a href="' . base_url() . '">WebEnhancer - Steroid pentru site-uri</a>.<br><br>Ca să confirmi înregistrarea, te rugăm să urmezi următorul link: <a href="' . base_url("signup/confirmregistration/" . $generated_hash) . '">' . base_url("signup/confirmregistration/" . $generated_hash) . '</a>.<b>AI GRIJĂ! Acest link este valabil doar pentru 30 de minute.</b><br><br>Dacă nu tu ai cerut această înregistrare, te rugăm să ignori email-ul.<br><br><br>Cu respect,<br>echipa WebEnhancer.';
                                $this->email->message($message_to_show);

                                $this->email->send();
                                $flash_to_show = ($this->session->userdata('language') == "english") ? "An email containing further information has been sent to your email address. Please access it and continue. Thanks! \xF0\x9F\x98\x81" : "Un mail care conține informațiile necesare inregistrării a fost trimis către adresa indicată. Te rugăm să accesezi mail-ul și să continui înregistrarea, conform pașilor indicați. Mulțumim! \xF0\x9F\x98\x81";
                                flash_redirect('success', $text_to_show, base_url("login"));
                            } else flash_redirect('error', 'Something went wrong.', base_url("signup"));
                        } else flash_redirect('error', 'recaptcha invalid.', base_url("signup"));
                    } else flash_redirect('error', 'recaptcha invalid.', base_url("signup"));
                } else flash_redirect('error', 'The account you\'re trying to register is already registered. Pick another email address', base_url("signup"));
            } else flash_redirect('error', 'Datele introduse sunt invalide.', base_url("signup"));
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