<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Login
* 
* 
* @package    T4P
* @subpackage Controller
*/

class Login extends CI_Controller {

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
            $data["logintitle"]                 = $this->lang->line("login_logintitle");
            $data["text_alternativebottom"]     = $this->lang->line("login_alternativebottom");
            $data["main_content"]               = 'login/login_view';
            $this->load->view('includes/template.php', $data);
        }
        else
        {
            $email      = $this->input->post('email');
            $password   = $this->input->post('password');
            
            if(strlen($email) && strlen($password)) {
                
                $result = $this->Login_model->return_user($email, $password);
            
                if($result)
                {
                    $sess_array = array(
                        "ID"        => $result->ID,
                        "EMail"     => $result->EMail,
                        "Role"      => $result->Role,
                        "PhotoName" => $result->PhotoName
                    );
                    $this->session->set_userdata("logged_in", $sess_array);
                    
                    $this->Login_model->insert_login($this->session->userdata("logged_in")["ID"], $this->input->ip_address());
                    
                    redirect(base_url("dashboard"));
                }
                else
                {
                    $this->session->set_flashdata('error', 'Datele introduse sunt invalide.');
                    redirect(base_url("login"));
                }
            } else {
                $this->session->set_flashdata('error', 'Datele introduse sunt invalide.');
                redirect(base_url("login"));
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
            if(getUserData($email, "Admin") == 0) {
                if(getUserData($email, "Email") != "email@yahoo.com") {
                    
                    $first = md5(uniqid());
				    $final_key = $first . md5($first);
                    
                    $this->Login_model->recoverPassword(getUserData($email, "ID"), $final_key);

                    $msg = $email . ",<br>
                        [RO] Ai primit acest email pentru ca ai solicitat resetarea parolei pe serverul rpg.t4p.ro<br>
                        Daca nu doresti sa iti schimbi parola, poti ignora/sterge acest email.<br>
                        Pentru a-ti schimba parola, da click pe link-ul de mai jos: <br>
                        <a href=\"" . base_url("login/recoverchange/$final_key") . "\">" . base_url("login/recoverchange/$final_key") . "</a>
                        <br>
                        <br>
                        [EN] You have recived this email because you have requested a reset of your password on rpg.t4p.ro<br>
                        If you don't want to change your password, please ignore this email. <br>
                        To change your password, please click the link above this message.<br>
                        <br><br>
                        Cu stima,<br>
                        Echipa T4P";
                    
                    $this->load->library('email', $this->config->item('smtp_array'));
                    $this->email->from('tpro@t4p.ro', 'Time4Play Romania');
                    $this->email->to('' . getUserData($email, "Email") . '');
                    $this->email->subject("PASSWORD RECOVERY - RPG.T4P.RO");
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
                $this->session->set_flashdata('error', 'Nu poti face o cerere de resetare a parolei pentru un cont de admin.');
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
        
        if($this->Login_model->isValidRecovery($recoverKey)) {
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
                $this->Login_model->updateUser($recoverKey, $initialPassword);

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