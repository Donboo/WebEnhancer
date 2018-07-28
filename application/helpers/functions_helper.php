<?php

/**
* 
* Get time difference between a date and current date
*
* @param string $date Date to convert 
* @return string
*
*/
function get_time_difference($date) 
 {
    if(empty($date)) {
        return "No date provided";
    }
    $periods         = array("seconds", "minutes", "hours", "days", "weeks", "months", "years", "decades");
    $lengths         = array("60","60","24","7","4.35","12","10");
    $now             = strtotime("-0 minutes");
    $unix_date       = strtotime($date);

    if(empty($unix_date)) {   
        return "Bad date";
    }

    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense = "ago";

    } else {
        $difference     = $unix_date - $now;
        $tense = "in";
    }

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    return (($now > $unix_date) ? ("$difference $periods[$j] {$tense}") : ("{$tense} $difference $periods[$j]"));
}

/**
* 
* Get time difference between a timestamp and current date
*
* @param integer $date Timestamp to difference 
* @return string
*
*/
function get_time_difference_timestamp($date) 
 {
    if(empty($date)) {
        return "No date provided";
    }
    $periods         = array("seconds", "minutes", "hours", "days", "weeks", "months", "years", "decades");
    $lengths         = array("60","60","24","7","4.35","12","10");
    $now             = strtotime("-0 minutes");
    $unix_date       = ($date);

    if(empty($unix_date)) {   
        return "Bad date";
    }

    if($now > $unix_date) {   
        $difference     = $now - $unix_date;

    } else {
        $difference     = $unix_date - $now;
    }

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    return "$difference $periods[$j]";
}

function get_info_name($name, $selector = '*') { 
    $ci =& get_instance();
    $ci->db->select($selector); 
    $ci->db->from('users'); 
    $ci->db->where('name', $name);
    $query = $ci->db->get(); 
    $data=array();
    if($query->num_rows() > 0) return $data->result(); 
}

function get_info($selector, $table, $firstkey, $key) {
    $ci =& get_instance();
    $query = $ci->db->query("SELECT `".$selector."` FROM `".$table."` WHERE `".$firstkey."` = '".$key."' ");
    return (isset($query->result()[0]->$selector) ? $query->result()[0]->$selector: "unknown");
}

function get_cached_info($selector, $table, $firstkey, $key) {
    $ci =& get_instance();
    $ci->db->cache_on();
    $query = $ci->db->query("SELECT `".$selector."` FROM `".$table."` WHERE `".$firstkey."` = '".$key."' ");
    return (isset($query->result()[0]->$selector) ? $query->result()[0]->$selector: "unknown");
}

function countTable($table, $extra = "") {
    $ci =& get_instance();
    $query = $ci->db->query("SELECT * FROM `" . $table . "` " . $extra);
    return $query->num_rows();
}

function base64Encoded($data)
{
    if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
       return TRUE;
    } else {
       return FALSE;
    }
};


function most_frequent_words($string, $stop_words = [], $limit = 5) { // stackoverflow
    $string = strtolower($string); // Make string lowercase

    $words = str_word_count($string, 1); // Returns an array containing all the words found inside the string
    $words = array_diff($words, $stop_words); // Remove black-list words from the array
    $words = array_count_values($words); // Count the number of occurrence

    arsort($words); // Sort based on count

    return array_slice($words, 0, $limit); // Limit the number of words and returns the word array
}

/* Sets a flash message then redirects */
function flash_redirect($type, $message, $where) {
    $CI =& get_instance();
    $CI->session->set_flashdata($type, $message);
    redirect($where);
}

function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if (!$beginningPos || !$endPos) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return str_replace($textToDelete, '', $string);
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function sqli_syntaxes() {
    $syntax = array(
        'version'       => array(
                                    'normal'        => "' UNION ALL SELECT NULL,version()--",
                                    'error'         => "' AND extractvalue(rand(),concat(0x3a,version()))--",
                                    'double'        => "' AND(SELECT 1 FROM(SELECT COUNT(*),concat(version(),FLOOR(rand(0)*2))x FROM information_schema.TABLES GROUP BY x)a)--",
                                    'inferential'   => "' AND IF((SELECT ascii(substr(version(),1,1))) > 53,sleep(10),NULL)--"
                                ),
        
        'login'         => array(
                                    'name' => "admin';--",
                                )
    );
    return $syntax;
}

function xss_syntaxes() {
    $syntax = array(
        '"></title><script>alert(1111)</script>',
        '<scrscriptipt>alert(1)</scrscriptipt>',
        '<h1>a</h1>',
        '<marquee><script>alert(/XSS/)</script></marquee>',
        'alert(String.fromCharCode(88,83,83));))">',
        '<img src=x onerror="&#0000106&#0000097&#0000118&#0000097&#0000115&#0000099&#0000114&#0000105&#0000112&#0000116&#0000058&#0000097&#0000108&#0000101&#0000114&#0000116&#0000040&#0000039&#0000088&#0000083&#0000083&#0000039&#0000041">',
        '<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29>'
    );
    return $syntax;
}

function get_injection_type($numeric) {
    switch ($numeric) {
        case 1:
            return "normal";
        case 2:
            return "error";
        case 3:
            return "double";
        case 4:
            return "inferential";
        default:
            return "normal";
    }
}

function html_minify($string) {
    return preg_replace('!\s+!', ' ', $string);
}

// stackoverflow
function rel2abs($rel, $base)
{
    /* return if already absolute URL */
    if (parse_url($rel, PHP_URL_SCHEME) != '' || substr($rel, 0, 2) == '//') return $rel;

    /* queries and anchors */
    if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;

    /* parse base URL and convert to local variables:
     $scheme, $host, $path */
     extract(parse_url($base));

    /* remove non-directory element from path */
    $path = preg_replace('#/[^/]*$#', '', $path);

    /* destroy path if relative url points to root */
    if ($rel[0] == '/') $path = '';

    /* dirty absolute URL */
    $abs = "$host$path/$rel";

    /* replace '//' or '/./' or '/foo/../' with '/' */
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

    /* absolute URL is ready! */
    return $scheme.'://'.$abs;
}
//

function isAbsolutePath($file)
{
    return strspn($file, '/\\', 0, 1)
        || (strlen($file) > 3 && ctype_alpha($file[0])
            && substr($file, 1, 1) === ':'
            && strspn($file, '/\\', 2, 1)
        )
        || null !== parse_url($file, PHP_URL_SCHEME)
    ;
}

function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function set_absolute_paths($content, $url) {
    $styles = array();
    $scripts = array();
    
    // GET STYLES
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    libxml_clear_errors();
    
    foreach ($dom->getElementsByTagName('link') as $node)
    {
        if(!isAbsolutePath($node->getAttribute("href")))
             $node->setAttribute('href', '//' . $url . '/' . $node->getAttribute("href"));
    }
    foreach ($dom->getElementsByTagName('script') as $node)
    {
        if(!isAbsolutePath($node->getAttribute("src")))
            $node->setAttribute('src', '//' . $url . '/' . $node->getAttribute("src"));
    }
    

    $content = $dom->saveHtml();
    return $content;
}

/**
* 
* Clear snapshot - No longer used - Here for historical reasons :'(
*
* @param string  $content            Content to clear
* @param string  $url                URL (needed for rel2abs)
* @return string
*
*/
function clear_snapshot($content, $url) {
    $styles = array();
    $scripts = array();
    
    // GET STYLES
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    libxml_clear_errors();
    
    foreach ($dom->getElementsByTagName('link') as $node)
    {
        array_push($styles, $node->getAttribute("href"));
    }
    
    // DELETE SCRIPTS
    for ($member_count = $dom->getElementsByTagName("script")->length; --$member_count >= 0; ) {
        $node = $dom->getElementsByTagName("script")->item($member_count);
        $node->parentNode->removeChild($node);
    }
    $content = $dom->saveHtml();
    
    // DELETE IFRAMES
    for ($member_count = $dom->getElementsByTagName("iframe")->length; --$member_count >= 0; ) {
        $node = $dom->getElementsByTagName("iframe")->item($member_count);
        $node->parentNode->removeChild($node);
    }
    $content = $dom->saveHtml();
    
    // DELETE HEADER
    $head_start = strrpos($content, "<head>");
    $head_stop = strrpos($content, "</head>");
    
     
    $content  = substr_replace($content, "", $head_start, $head_stop);

    $new_head = "<head>";
    
    foreach($styles as $style) {
        $parse = parse_url($url);
        $href = $parse['host'] . "/" . $style;
        $new_head .= "<link rel='stylesheet' href='" .  rel2abs($style, $url) . "'>";
    }
    
    $new_head .= "</head>";
    
    $snapshot = str_replace("</head>", $new_head, $content);
    return $snapshot;
}

/**
* 
* Check if something exists
*
* @param integer  $refID                Reference ID in table
* @param string   $table                Provided table
* @param string   $identificatior       Identificator 
* @return boolean
*
*/
function exists($refID, $table, $identificator = "`ID`") {
    $ci =& get_instance();
    $query = $ci->db->query("SELECT ID FROM `".$table."` WHERE $identificator = '".$refID."' LIMIT 1");
    return ($query->num_rows() ? true : false);
}

/**
* 
* Get location of an IP by IPStack.com Free API
*
* @param string   $IP               IP to provide
* @param boolean  $useHead          Use headers?
* @return string
*
*/
function get_ip_location($IP) {
    $APIKEY     = "189dadc9f0e4de1b77feaf12215cf5e9";
    $info       = json_decode(get_data("http://api.ipstack.com/$IP?access_key=$APIKEY&format=1"));
    return $info->city . ", " . $info->region_name . ", " . $info->country_name;
}

/**
* 
* Format a size (number)
*
* @param integer  $number           Number to be formatted
* @return string
*
*/
function format_size($number) {
    switch ($number) {
        case $number < 1024:
            $size = $number .' B'; break;
        case $number < 1048576:
            $size = round($number / 1024, 2) .' KiB'; break;
        case $number < 1073741824:
            $size = round($number / 1048576, 2) . ' MiB'; break;
        case $number < 1099511627776:
            $size = round($number / 1073741824, 2) . ' GiB'; break;
    }
    return $size;
}

/**
* 
* Get size of a resource file
*
* @param string   $url              URL to check
* @param boolean  $formatSize       Should return the number of the formatted number?
* @param boolean  $useHead          Use headers?
* @return string
*
*/
function getRemoteFilesize($url, $formatSize = true, $useHead = true)
{
    if (false !== $useHead) {
        stream_context_set_default(array('http' => array('method' => 'HEAD')));
    }
    @$headers = get_headers($url, 1);
    if($headers) {
        $head = array_change_key_case(get_headers($url, 1));

        $clen = isset($head['content-length']) ? $head['content-length'] : 0;

        if (!$clen) {
            return 0;
        }

        if (!$formatSize) {
            return $clen; 
        }

        $size = $clen;
        switch ($clen) {
            case $clen < 1024:
                $size = $clen .' B'; break;
            case $clen < 1048576:
                $size = round($clen / 1024, 2) .' KiB'; break;
            case $clen < 1073741824:
                $size = round($clen / 1048576, 2) . ' MiB'; break;
            case $clen < 1099511627776:
                $size = round($clen / 1073741824, 2) . ' GiB'; break;
        }

        return $size;
    } else return "unavailable site.";
}

/* God bless Stack */
/**
* 
* Get domain root
*
* @param string  $url               URL to check
* @return string
*
*/
function get_domain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}
/**/


/**
* 
* Get HTTP Code of a website
*
* @param string  $url  URL to check
* @return string
*
*/
function get_http_code($url) 
{
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}


/**
* 
* Calculate "OUR GRADE" @ Results
*
* @param integer $size              File size
* @param string  $ext               Extension type
* @param integer $redirect_time     Redirect time (if any?!)
* @param integer $http_code         HTTP Code of file
* @return string
*
*/
function calculate_grade($size, $ext, $redirect_time, $http_code) 
{
    switch($ext) {
        case 'css':
             if($size < 1024*100) {
                if($redirect_time == 0) {
                    if($http_code == "200" || $http_code == "301") {
                        return "OK";
                    } else return "<abbr title='HTTP Code should be 200 or 301 for all your resources.'>NOT OK (HTTP CODE)</abbr>";
                } else return "<abbr title='To access this resources, the connection is redirected. Remove this redirect.'>NOT OK (REDIRECT)</abbr>";
            } else return "<abbr title='Your size excedes our recommendations.'>NOT OK (SIZE)</abbr>";
            break;
        case 'js':
             if($size < 1024*150) {
                if($redirect_time == 0) {
                    if($http_code == "200" || $http_code == "301") {
                        return "OK";
                    } else return "<abbr title='HTTP Code should be 200 or 301 for all your resources.'>NOT OK (HTTP CODE)</abbr>";
                } else return "<abbr title='To access this resources, the connection is redirected. Remove this redirect.'>NOT OK (REDIRECT)</abbr>";
            } else return "<abbr title='Your size excedes our recommendations.'>NOT OK (SIZE)</abbr>";
            break;
        case 'html':
            if($size < 1024*50) {
                if($redirect_time == 0) {
                    if($http_code == "200" || $http_code == "301") {
                        return "OK";
                    } else return "<abbr title='HTTP Code should be 200 or 301 for all your resources.'>NOT OK (HTTP CODE)</abbr>";
                } else return "<abbr title='To access this resources, the connection is redirected. Remove this redirect.'>NOT OK (REDIRECT)</abbr>";
            } else return "<abbr title='Your size excedes our recommendations.'>NOT OK (SIZE)</abbr>";
            break;
        default:
            return "?";
            break;
    }
}

/**
* 
* Get a random background
*
* @return string
*
*/
function random_hero() {
    $color = array("is-primary is-bold", "is-primary", "is-link is-bold", "is-link", "is-success is-bold", "is-success");
    return $color[mt_rand(0, count($color) - 1)];
}

/**
* 
* Get the HTML version of a webpage by publicId
*
* @param string $public_id Type to analyze
* @return string
*
*/
function get_html_version($public_id) {
    $public_id = strtoupper($public_id);
    if(strlen($public_id) < 3) return "HTML5";
    
    switch($public_id) {
        case '-//W3C//DTD HTML 4.01//EN':
            return "HTML 4.01 Strict";
        break;
        case '-//W3C//DTD HTML 4.01 TRANSITIONAL//EN"':
            return "HTML 4.01 Transitional";
        break;
        case '-//W3C//DTD HTML 4.01 FRAMESET//EN':
            return "HTML 4.01 Frameset";
        break;
        case '-//W3C//DTD XHTML 1.0 STRICT//EN':
            return "XHTML 1.0 Strict";
        break;
        case '-//W3C//DTD XHTML 1.0 TRANSITIONAL//EN':
            return "XHTML 1.0 Transitional";
        break;
        case '-//W3C//DTD XHTML 1.0 FRAMESET//EN':
            return "XHTML 1.0 Frameset";
        break;
        case '-//W3C//DTD XHTML 1.1//EN':
            return "XHTML 1.1";
        break;
        default:
            return "unknown";
        break;
    }
}

/**
* 
* Check if URL is alive
*
* @param string $url URL to check
* @return string
*
*/
function check_if_alive($url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    if(in_array($headers['http_code'], array("200", "301", "302"))) return true;
    else return false;
}

/**
* 
* Convert special characters from HTML Validator API to readable ones
*
* @param string $text Text to convert 
* @return string
*
*/
function alive_validate_messages($text) {
    return htmlentities(str_replace('u201c', '<', str_replace('u201d', '>', $text)));
}

?>