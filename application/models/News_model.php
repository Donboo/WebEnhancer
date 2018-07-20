<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* News
* 
* 
* @package    WebEnhancer
* @subpackage Model
*/

class News_model extends CI_model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function check_user_exists($email) {
        
    }
    
    public function insert_user($email, $password)
    {   
        // salt = random_string('alnum', 16);
        
        $query = $this->db->query
                 (
                    "SELECT ID, Role, IP FROM `" . $this->config->config['tables']['accounts'] . "` WHERE `EMail` = ? AND `Password` = ? LIMIT 1", 
                    array($email, hash("sha256",  "mOGhbVyt!4JkL" . implode(get_info("Salt", "accounts", "EMail", $email), str_split($password, floor(strlen($password)/2))) . get_info("Salt", "accounts", "EMail", $email)))
                 );
        
        if($query->num_rows()) return $query->result();
        else return array();
    }
    
    public function return_user($email, $password)
    {   
        $query = $this->db->query
                 (
                    "SELECT ID, EMail, Role, IP FROM `" . $this->config->config['tables']['accounts'] . "` WHERE `EMail` = ? AND `Password` = ? LIMIT 1", 
                    array($email,  hash("sha256", "mOGhbVyt!4JkL" . implode(get_info("Salt", "accounts", "EMail", $email), str_split($password, floor(strlen($password)/2))) . get_info("Salt", "accounts", "EMail", $email)))
                 );
        
        if($query->num_rows()) return $query->result()[0];
        else return array();
    }
    
    public function insert_login($userID, $IP) {
        $this->db->query("INSERT INTO `" . $this->config->config['tables']['logins'] . "` (`UserID`, `IP`, `Time`) VALUES (?, ?, ?)", array($userID, $IP, date("Y-m-d H:i:s")));
    }
    
    public function get_projects($user_id) {
        $this->db->cache_on();
        $query = $this->db->query("SELECT URL, Date FROM " . $this->config->config['tables']['projects'] . " WHERE OwnerID = ? ORDER BY ID DESC", array($user_id));
        
        if($query->num_rows()) return $query->result_array();
        else return 0;
    }
    
    function get_news() {
        $this->db->cache_on();
        $query = $this->db->query("SELECT ID, Content, Image FROM " . $this->config->config['tables']['news'] . " ORDER BY Date DESC");
        
        if($query->num_rows()) return $query->result_array();
        else return 0;
    }

}