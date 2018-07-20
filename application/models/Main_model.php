<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Main
* 
* 
* @package    WebEnhancer
* @subpackage Model
*/

class Main_model extends CI_model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function get_last_news() {
        $this->db->cache_on();
        $query = $this->db->query("SELECT Content FROM " . $this->config->config['tables']['news'] . " ORDER BY ID DESC LIMIT 1");
        
        if($query->num_rows()) return $query->result_array();
        else return 0;
    }

}