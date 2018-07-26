<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* WebEnhancer
* 
* 
* @package    WebEnhancer
* @subpackage Model
*/

class WebEnhancer_model extends CI_model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function insert_result($url, $tester, $useragent, $snapshot, $data, $score) {
        $query = $this->db->query("INSERT INTO " . $this->config->config['tables']['results'] . " (`URL`, `Tester`, `UA`, `Snapshot`, `Data`, `Scores`, `Time`) VALUES (?, ?, ?, ?, ?, ?, ?)", 
                                  array(
                                      $url, 
                                      $tester, 
                                      $useragent, 
                                      $snapshot, 
                                      stripslashes(stripslashes($data)), 
                                      stripslashes(stripslashes($score)), 
                                      date("Y-m-d H:i:s")));
        
    }

}