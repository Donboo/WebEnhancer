<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* GlobalVars
* 
* 
* @package    WebEnhancer
* @subpackage Helper
*/
class GlobalVars
{
    
    static $load_message = null;
    static $dom_message  = null;
    
    static $initialized  = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        self::$load_message = null;
        self::$dom_message  = null;
        
        self::$initialized  = true;
    }
    
    public static function domMessage()
    {
        self::initialize();
        return self::$dom_message;
    }
    
    public static function setDOMMessage($message)
    {
        self::initialize();
        self::$dom_message = $message;
    }
    
    public static function setLoadMessage($message)
    {
        self::initialize();
        self::$load_message = $message;
    }

    public static function loadMessage()
    {
        self::initialize();
        return self::$load_message;
    }
}