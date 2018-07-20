<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Login
* 
* 
* @package    WebEnhancer
* @subpackage Model
*/

class Login_model extends CI_model {
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
    }
    
    public function check_user_exists($email) {
        
    }
    
    public function insert_user($email, $password, $salt, $ip)
    {   
        $this->db->query("INSERT INTO `" . $this->config->config['tables']['accounts'] . "` (`EMail`, `Password`, `Salt`, `IP`) VALUES (?, ?, ?, ?)", array(
            $email,
            $password,
            $salt,
            $ip
        ));
        return true;
    }
    
    public function return_user($email, $password)
    {   
        $query = $this->db->query
                 (
                    "SELECT ID, EMail, Role, IP, PhotoName FROM `" . $this->config->config['tables']['accounts'] . "` WHERE `EMail` = ? AND `Password` = ? LIMIT 1", 
                    array($email,  hash("sha256", "mOGhbVyt!4JkL" . implode(get_info("Salt", "accounts", "EMail", $email), str_split($password, floor(strlen($password)/2))) . get_info("Salt", "accounts", "EMail", $email)))
                 );
        
        if($query->num_rows()) return $query->result()[0];
        else return array();
    }
    
    public function insert_login($userID, $IP) {
        $this->db->query("INSERT INTO `" . $this->config->config['tables']['logins'] . "` (`UserID`, `IP`, `Time`) VALUES (?, ?, ?)", array($userID, $IP, date("Y-m-d H:i:s")));
    }

}