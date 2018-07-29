<?php 

if(!defined('BASEPATH')) exit('No direct access allowed');
 
/**
* Function Tester
* 
* 
* @package    FunctionTester
* @subpackage Controller
*/

class FunctionTester extends CI_Controller
{
 
    public function __construct() {
        parent::__construct();
        $this->load->library('unit_test');
    }
    
    
    public function index() {
        self::test_get_time_difference(date("d-m-Y H:i:s", time()));
        self::test_get_time_difference_timestamp(time());
        self::test_delete_all_between("Web", "Enhancer", "Web is about to be part of the Enhancer movement.");
        self::test_get_injection_type(3);
        self::test_format_size(500);
        self::test_transform_array_into_argv(array("name"=>"webenhancer"));
        self::test_get_html_version('-//W3C//DTD XHTML 1.1//EN');
        self::test_calculate_grade(1024*149, "js", 0, 200);
        self::test_get_http_code("342", 1);
        self::test_get_http_code("http://youknowwhatimsaying.psd/", 1);
        self::test_get_http_code("http://youknowwhatimsaying.psd/", 0);
    }
    
    private function test_get_time_difference($date) {
        $test = get_time_difference($date);
        
        $expected_result = "in 0 seconds";
        $test_name       = 'function get_time_difference';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_get_time_difference_timestamp($timestamp) {
        $test = get_time_difference_timestamp($timestamp);
        
        $expected_result = "0 seconds";
        $test_name       = 'function get_time_difference_timestamp';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_delete_all_between($starting_with, $ending_with, $string) {
        $test = delete_all_between($starting_with, $ending_with, $string);
        
        $expected_result = " movement.";
        $test_name       = 'function delete_all_between';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_get_injection_type($number) {
        $test = get_injection_type($number);
        
        $expected_result = "double";
        $test_name       = 'function get_injection_type';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_format_size($number) {
        $test = format_size($number);
        
        $expected_result = "500 B";
        $test_name       = 'function format_size';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_transform_array_into_argv($array) {
        $test = transform_array_into_argv($array);
        
        $expected_result = "name=webenhancer";
        $test_name       = 'function transform_array_into_argv';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_get_html_version($version) {
        $test = get_html_version($version);
        
        $expected_result = "XHTML 1.1";
        $test_name       = 'function get_html_version';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }

    private function test_calculate_grade($size, $ext, $redirect_time, $http_code) {
        $test = calculate_grade($size, $ext, $redirect_time, $http_code);
        
        $expected_result = "OK";
        $test_name       = 'function calculate_grade';
        $test_arg        = 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
    private function test_get_http_code($url, $mode) {
        $test = get_http_code($url);
        
        $expected_result = "error";
        $test_name       = 'function get_http_code';
        $test_arg        = $mode ? 'testing invalid arguments' : 'testing valid arguments';

        echo $this->unit->run($test, $expected_result, $test_name, '<b>Expected output:</b> '.$expected_result.'<br><b>Because:</b> '.$test_arg.'.');
    }
    
}