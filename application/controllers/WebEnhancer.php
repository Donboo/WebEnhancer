<?php 

if(!defined('BASEPATH')) exit('No direct access allowed');
 
/**
* Web Enhancer
* 
* 
* @package    WebEnhancer
* @subpackage Controller
*/

class WebEnhancer extends CI_Controller
{

    // VAR
    var $generalScore;
    var $generalData;
    
    public function __construct() {
        parent::__construct();
        ini_set('max_execution_time', 300);
        
        $this->generalScore = array(
            "security"=>array(
                "xss"=>0,
                "sqli"=>0,
                "mis"=>array(
                    "autocomplete"=>0,
                    "headers"=>0,
                    "powered"=>0
                ),
                "ssl"=> 0
            ),
            "code"=>array(
                "valid"=>0,
                "doctype"=>0,
                "encoding"=>0,
                "dom"=>0
            ),
            "speed"=>array(
                "minified"=>0,
                "load"=>0
            ),
            "seo"=>array(
                "meta"=>array(
                    "keywords"=>0,
                    "description"=>0,
                    "title"=>0
                ),
                "responsive"=>0,
                "inline"=>0,
            )
        );

        $this->generalData = array(
            "security"=>array(
                "xssdesc"=>"none",
                "sqlidesc"=>"none",
                "misdesc"=>array(
                    "autocompletedesc"=>"none",
                    "headersdesc"=>"none",
                    "powereddesc"=>"none"
                ),
                "ssldesc"=>"none"
            ),
            "code"=>array(
                "validdesc"=>"none",
                "doctype"=>"none",
                "encoding"=>"none",
                "domdesc"=>"none"
            ),
            "speed"=>array(
                "minifieddesc"=>"none",
                "loaddesc"=>"none"
            ),
            "seo"=>array(
                "meta"=>array(
                    "keywordsdesc"=>"none",
                    "descriptiondesc"=>"none",
                    "titledesc"=>"none"
                ),
                "responsivedesc"=>"none"
            )
        );

        
        $this->load->model("WebEnhancer_model");
        
    }

    public function index() {
        redirect(base_url());
    }
    
    /**
    *
    * function start_test()
    *
    * Get given url
    * Run tests: 
    *               1. Check if url is real
    *               2. Check website's speed
    *               3. Check website's code
    *               4. Check website's SEO
    *               5. Check website's audit
    * Create snapshot
    * Insert in database
    *
    */
    public function start_test() {
        
        // SHOW SOMETHING...
        
        // GETTING THE URL
        $given_url = $this->input->post('testinput');
        
        // CHECKING IF URL
        $given_url = self::test_url($given_url);
        
        // TESTUL 1 - SPEED TEST
        self::test_speed($given_url);
        
        // TESTUL 2 - CODE VALIDATOR
        self::test_code($given_url);
        
        // TESTUL 3 - SEO HELPER
        self::test_seo($given_url);
        
        // TESTUL 4 - AUDIT SECURITATE
        self::test_audit($given_url);
        
        $snapshot   = clear_snapshot(file_get_contents($given_url), $given_url);
        
        $data = json_encode(array(
            "security"=>array(
                "xssdesc"=>"none",
                "sqlidesc"=>"none",
                "misdesc"=>array(
                    "autocompletedesc"=>$this->generalData['security']['mis']['autocompletedesc'],
                    "headersdesc"=>$this->generalData['security']['mis']['headersdesc'],
                    "powereddesc"=>$this->generalData['security']['mis']['powereddesc']
                ),
                "ssldesc"=>"none"
            ),
            "code"=>array(
                "validdesc"=>$this->generalData['code']['validdesc'],
                "doctype"=>$this->generalData['code']['doctype'],
                "encoding"=>$this->generalData['code']['encoding'],
                "domdesc"=>$this->generalData['code']['domdesc']
            ),
            "speed"=>array(
                "minifieddesc"=>"none",
                "loaddesc"=>$this->generalData['speed']['loaddesc']
            ),
            "seo"=>array(
                "meta"=>array(
                    "keywordsdesc"=>$this->generalData['seo']['meta']['keywordsdesc'],
                    "descriptiondesc"=>$this->generalData['seo']['meta']['descriptiondesc'],
                    "titledesc"=>$this->generalData['seo']['meta']['titledesc']
                ),
                "responsivedesc"=>$this->generalData['seo']['responsivedesc']
            )
        ));
        $json_data  = json_encode($data,JSON_UNESCAPED_SLASHES);
        //die(str_replace('"{', '{', str_replace('}"', '}',str_replace('\\/\\/', '//', str_replace('\"', '"', str_replace('\\\"', '"', $json_data))))));
        
        $score = json_encode(array(
            "security"=>array(
                "xss"=>0,
                "sqli"=>0,
                "mis"=>array(
                    "autocomplete"=>$this->generalScore['security']['mis']['autocomplete'],
                    "headers"=>$this->generalScore['security']['mis']['headers'],
                    "powered"=>$this->generalScore['security']['mis']['powered']
                ),
                "ssl"=>$this->generalScore['security']['ssl']
            ),
            "code"=>array(
                "valid"=>$this->generalScore['code']['valid'],
                "doctype"=>$this->generalScore['code']['doctype'],
                "encoding"=>$this->generalScore['code']['encoding'],
                "dom"=>$this->generalScore['code']['dom']
            ),
            "speed"=>array(
                "minified"=>0,
                "load"=>$this->generalScore['speed']['load']
            ),
            "seo"=>array(
                "meta"=>array(
                    "keywords"=>$this->generalScore['seo']['meta']['keywords'],
                    "description"=>$this->generalScore['seo']['meta']['description'],
                    "title"=>$this->generalScore['seo']['meta']['title']
                ),
                "responsive"=>$this->generalScore['seo']['responsive'],
                "inline"=>0
            )
        ));
        $json_score  = json_encode($score,JSON_UNESCAPED_SLASHES);
        
        $this->WebEnhancer_model->insert_result($given_url, $this->input->ip_address(), "0", $snapshot, str_replace('"{', '{', str_replace('}"', '}',str_replace('\\/\\/', '//', str_replace('\"', '"', str_replace('\\\"', '"', $json_data))))), str_replace('"{', '{', str_replace('}"', '}',str_replace('\\/\\/', '//', str_replace('\"', '"', str_replace('\\\"', '"', $json_score))))));
        flash_redirect('success', '', base_url("WebEnhancer/results/" . $this->db->insert_id()));
        
    }

    /**
    *
    * function results()
    *
    * Show results for specific test id
    *
    * @return view
    */
    function results() {
        if(!is_numeric($this->uri->segment(3)) || !is_numeric(get_info("ID", "results", "ID", $this->uri->segment(3)))) {
           flash_redirect('error', $this->lang->line('main_invalidresultid'), base_url());
        }
        
        $result_id = $this->uri->segment(3);
        
        $data["url"]                                = get_cached_info("URL", "results", "ID", $result_id);
        
        $google_data                                = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=".$data["url"]."&screenshot=true");
        $google_data                                = json_decode($google_data, true);
        $screenshot                                 = $google_data['screenshot']['data'];
        
        $google_mobile                              = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=".$data["url"]."&screenshot=true&strategy=mobile");
        $google_mobile                              = json_decode($google_mobile, true);
        $screenshot2                                = $google_mobile['screenshot']['data'];
    
        $data["snapshot"]                           = str_replace(array('_','-'),array('/','+'),$screenshot);
        $data["snapshot_mobile"]                    = str_replace(array('_','-'),array('/','+'),$screenshot2);

        $data["sitename"]                           = parse_url($data["url"])['host'];
        $data["data_result"]                        = json_decode(str_replace('"{', '{', str_replace('}"', '}',str_replace('\\/\\/', '//', str_replace('\"', '"', str_replace('\\\"', '"', get_cached_info("Data", "results", "ID", $result_id)))))));
        $data["score_result"]                       = json_decode(str_replace('"{', '{', str_replace('}"', '}', str_replace('\"','"',get_cached_info("Scores", "results", "ID", $result_id)))));
        $data["resultid"]                           = $result_id;
        
        // TRANSLATE
        $data["resultsready"]                       = $this->lang->line('main_resultsready');
        $data['speedtests']                         = $this->lang->line('main_speedtests');
        $data['codevalidator']                      = $this->lang->line('main_codevalidator');
        $data['seohelper']                          = $this->lang->line('main_seohelper');
        $data['securityaudit']                      = $this->lang->line('main_securityaudit');
        $data['shortreview']                        = $this->lang->line('main_shortreview');
        $data['has_been_analyzed']                  = $this->lang->line('main_hasbeenanalyzed');
        $data['text_why_is_security_important']     = $this->lang->line('main_why_security');
        $data['text_answer_security_important']     = $this->lang->line('main_answer_security');
        $data['text_why_is_seo_important']          = $this->lang->line('main_why_seo');
        $data['text_answer_seo_important']          = $this->lang->line('main_answer_seo');
        $data['text_descrleng']                     = $this->lang->line('main_descrleng');
        $data['text_titleleng']                     = $this->lang->line('main_titleleng');
        $data['text_keywordsleng']                  = $this->lang->line('main_keywordsleng');
        $data['text_guidelines']                    = $this->lang->line('main_guidelines');
            
        $data['totalSEO']                           = $data["score_result"]->seo->meta->keywords + $data["score_result"]->seo->meta->title + $data["score_result"]->seo->meta->description + $data["score_result"]->seo->responsive;    
        $data['totalSpeed']                         = 15;    
        $data['totalCode']                          = $data["score_result"]->code->valid + $data["score_result"]->code->doctype + $data["score_result"]->code->encoding + $data["score_result"]->code->dom; 
        $data['totalSecurity']                      = $data["score_result"]->security->xss + $data["score_result"]->security->sqli + $data["score_result"]->security->mis->headers + $data["score_result"]->security->mis->powered + $data["score_result"]->security->mis->autocomplete + $data["score_result"]->security->ssl; 
        
        $data["main_content"] = 'webenhancer/webenhancer_view';
        $this->load->view('includes/template.php', $data);
    }
    
    /**
    *
    * function test_url($given_url)
    *
    * Filter if given url is url
    * Check headers
    * If checking headers fails, try switching the protocol
    * Check headers again
    * If checking headers fails, redirect with flash error
    *
    * @param string $given_url
    */
    function test_url($given_url) {
        if (!(filter_var($given_url, FILTER_VALIDATE_URL))) {
            flash_redirect('error', $this->lang->line('main_invalidurl'), base_url());
        }
        
        $host = parse_url($given_url);
        if(in_array($host['host'], array("127.0.0.1", "localhost", "192.168.0.1"))) {
            flash_redirect('error', $this->lang->line('main_invalidurl'), base_url());
        }
        
        $header_check = get_headers($given_url);
        $response_code = $header_check[0];
        // HTTP/1.1 301 Moved Permanently

        if(!in_array($response_code, array("HTTP/1.1 200 OK", "HTTP/1.1 302 Found", "HTTP/1.0 200 OK", "HTTP/1.0 302 Found", "HTTP/2.0 200 OK", "HTTP/2.1 302 Found"))) {
            if(strpos($given_url, "https://") !== false) $given_url = str_replace("https://", "http://", $given_url); 
            elseif(strpos($given_url, "http://") !== false) $given_url = str_replace("http://", "https://", $given_url);
            $header_check = get_headers($given_url);
            $response_code = $header_check[0];
            // HTTP/1.1 301 Moved Permanently

            if(!in_array($response_code, array("HTTP/1.1 200 OK", "HTTP/1.1 302 Found", "HTTP/1.0 200 OK", "HTTP/1.0 302 Found", "HTTP/2.0 200 OK", "HTTP/2.1 302 Found"))) {
                flash_redirect('error', $this->lang->line('main_offlineurl'), base_url());
            }
        }
        
        return $given_url;
    }
    
    function test_speed($given_url) {
        
        self::test_if_minified($given_url);
        
        $sourceUrl                              = parse_url($given_url);
        $sourceUrl                              = $sourceUrl['host'];
        
        sleep(3);
        
        echo "<script type='text/javascript'>window.open('".base_url("webenhancer/loadtest/".$sourceUrl)."')</script>";
        
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $dom->loadHTML(file_get_contents($given_url));
        libxml_clear_errors(true);
        
        $links      = array();
        $scripts    = array();
        $errors     = array();
        
        foreach ($dom->getElementsByTagName('link') as $node)
        {
            array_push($links, $node->getAttribute("href"));
        }
        foreach ($dom->getElementsByTagName('script') as $node)
        {
            if(strlen($node->getAttribute("src"))) array_push($scripts, "[src]" . $node->getAttribute("src"));
            else array_push($scripts, "[content]" . $node->nodeValue);
            
            foreach (libxml_get_errors() as $error)
            {
                array_push($errors, $error);
            }
        }
//        die(print_r($scripts));

        // DELETE SCRIPTS
        for ($member_count = $dom->getElementsByTagName("script")->length; --$member_count >= 0; ) {
            $node = $dom->getElementsByTagName("script")->item($member_count);
            $node->parentNode->removeChild($node);
        }
        $content = $dom->saveHtml();
  
    }
    
    function test_if_minified($url_content) {
        return preg_match('/^[^\n\r]+(\r\n?|\n)?$/', $url_content, $match) ? $this->generalScore['code']['minified'] = 1 : $this->generalScore['code']['minified'] = 0;
    }
    
    function test_code($given_url) {
        
        $url_content                            = file_get_contents($given_url);
        
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $dom->loadHTML($url_content);
        libxml_clear_errors(true);
        
        $this->generalData['code']['doctype']   = $dom->doctype->publicId;
        if(get_html_version($dom->doctype->publicId) == "HTML5") $this->generalScore['code']['doctype']  = 25;
        else $this->generalScore['code']['doctype']  = 0;
        
        //$get_encoding                           = preg_match('~charset=([-a-z0-9_]+)~i',$url_content,$matches);
        $encoding                               = "UTF-8";//$matches[1][0];
        $this->generalData['code']['encoding']  = $encoding;
        $this->generalScore['code']['encoding'] = 25;
            
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, "https://validator.w3.org/nu/?out=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array("doc"=>$given_url)));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=utf-8'));
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // execute post
        $result = curl_exec($ch);
        
        $newjson            ='{"messages":{';
        $result_decoded     = json_decode($result);
        
        $counter = 0; // another purpose.. nu setez degeaba :)
        // mai nou sunt si chirurg de trb sa dezmembrez jsonu sa l fac cum vreau eu........
        for($counter = 0; $counter < count((array)$result_decoded, 1); $counter++) {
            if(isset($result_decoded->messages[$counter])) {
                $newjson .='"'.$counter.'":{"type":"'.($result_decoded->messages[$counter]->type).'","line":"'.($result_decoded->messages[$counter]->lastLine).'","message":"'.($result_decoded->messages[$counter]->message).'"}';
                if($counter != count((array)$result_decoded, 1)) $newjson .= ',';
            } else {
                $newjson = rtrim($newjson, ',');
            }
        }
        
        $newjson .= '}}';
        
        $this->generalData['code']['validdesc'] = $newjson;
        $this->generalScore['code']['valid']    = ($counter>0) ? 0 : 25;

        // close connection
        curl_close($ch);
        
        $sourceUrl          = parse_url($given_url);
        $sourceUrl          = $sourceUrl['host'];
        
        sleep(3);
        
        echo "<script type='text/javascript'>window.open('".base_url("webenhancer/domelements/".$sourceUrl)."')</script>";
        
        // count tags exclude <br> <meta><link>
        
        // MINIFY CONTENT
        
        /* COUNT TAGS
        $html_tag = countable_html_tags();
        $output='';
        foreach($html_tag as $tag) {
            $output .= $tag . ": " . substr_count($url_content, "<" . $tag) . ", ";
        }
        */
    }
    
    // TEST SECURITY AUDIT
    function test_audit($given_url) {
        self::test_audit_ssl($given_url);
        self::test_audit_sql($given_url);
        self::test_audit_xss($given_url);
        self::test_audit_mis($given_url);
    }
    
    
    // TEST SECURITY AUDIT: SSL
    function test_audit_ssl($given_url) {
        if(strpos($given_url, "http://") !== false) $given_url = str_replace("http://", "https://", $given_url);
        
        if(strlen(@file_get_contents($given_url))) {
            $stream = stream_context_create ( array( "ssl" => array( "capture_peer_cert" => true ) ) );

            $read   = fopen( $given_url, "rb", false, $stream );
            $param  = stream_context_get_params( $read );

            $certificate_read   = $param["options"]["ssl"]["peer_certificate"];
            $result_given = ( !is_null( $certificate_read ) ) ? true : false;
            if($result_given) { 
                $this->generalData['security']['ssldesc'] = 'SSL on point.';
                $this->generalScore['security']['ssl'] = 14.28;
              }
        } else {
            $this->generalData['security']['ssldesc'] = 'SSL is not available.';
            $this->generalScore['security']['ssl'] = 0;
        }
    }
    
    // TEST SECURITY AUDIT: SQLI
    function test_audit_sql($given_url) {
        
        // VERSIUNEA 1 - INPUTURI
        $url_content = file_get_contents($given_url); 

        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $dom->loadHTML($url_content);
        libxml_clear_errors(true);
        
        $form_actions      = array();
        $form_methods      = array();
        
        foreach ($dom->getElementsByTagName('form') as $node)
        {
            strlen($node->getAttribute('action')) ? array_push($form_actions, $node->getAttribute('action')) : array_push($form_methods, $node->getAttribute('method') . "[urlform] $given_url [/urlform]");
        }
        
        /*$form = substr($url_content, strpos($url_content, "<form"));    
        $cont = get_string_between($form, "<form", "</form>");
        
        $inputs      = array();
        $textareas   = array();
        
        foreach ($dom->getElementsByTagName('input') as $node)
        {
            if(!in_array($node->getAttribute('name'), array('_token', 'CSRF_TOKEN', '_csrf_header', '_csrf', 'csrf-token'))) { 
                array_push($inputs, $node->getAttribute('name') . "[40Khsbn240801Bnak]" . $node->getAttribute('type')); 
            }
        }
        foreach ($dom->getElementsByTagName('textarea') as $node)
        {
            array_push($textareas, $node->getAttribute('name'));
        }
        
        if(sizeof($inputs) > 0) {
            if(isset($form_actions[0])) $url = $form_actions[0];
            else { 
                $creator    = explode('[urlform] ', $form_methods[0]);
                $method     = $creator[0];
                $url        = str_replace(" [/urlform]", "", $creator[1]);
            }
            $arrayinputs    = array();
            $sql_syntaxes   = sqli_syntaxes();
            
            for($injection_count = 0; $injection_count < count($sql_syntaxes, 1); $injection_count++) {
                for($i = 0; $i < sizeof($textareas); $i++) {
                    $arrayinputs[$textareas[$i]] = $sql_syntaxes['version'][get_injection_type($injection_count)];
                }
                for($i = 0; $i < sizeof($inputs); $i++) { 
                    $input_exploder = explode('[40Khsbn240801Bnak]', $inputs[$i]);
                    $input_name[$i] = $input_exploder[0];
                    $input_type[$i] = $input_exploder[1];

                    if($input_type[$i] == 'url') {
                        $arrayinputs[$input_name[$i]] = "https://google.com/";
                    }
                    else if($input_type[$i] == 'email') {
                        $arrayinputs[$input_name[$i]] = "default@yahoo.com";
                    }
                    else if($input_type[$i] == 'number') {
                        $arrayinputs[$input_name[$i]] = 1;
                    }
                    else {
                        $arrayinputs[$input_name[$i]] = $sql_syntaxes['version'][get_injection_type($injection_count)];
                    }
                }
                $dom->saveHtml();

                // open connection
                $ch = curl_init();

                // set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, count($arrayinputs));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arrayinputs));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

                // execute post
                $result = curl_exec($ch);
                die($result);

                // close connection
                curl_close($ch);
            }
        }*/
        
        
        // VERSIUNEA 2 - URL
        //soon
        
        //todo
        // search in string dupa inputuri-required
        // de modificat valoarea selected si afisata
        // de dat post si retrieve la raspuns si header
        
        // VERSIUNEA 2 - PARAMETRI
    }
    
     // TEST SECURITY AUDIT: XSS
    function test_audit_xss($given_url) {
        
        // VERSIUNEA 1 - INPUTURI
        $url_content = file_get_contents($given_url);
        $form = substr($url_content, strpos($url_content, "<form"));    
       // echo "<pre><form" . get_string_between($form, "<form", "</form>");
        
        //todo
        // search in string dupa inputuri-required
        // de modificat valoarea selected si afisata
        // de dat post si retrieve la raspuns si header
        
        // VERSIUNEA 2 - PARAMETRI
    }
    
    /*
        function test_audit_mis($given_url)
        Check robots.txt, admincp's and so on
        @return set in webenhancer security misc array
        pooop
    
    */
    function test_audit_mis($given_url) {
        
        /*
        *
        * ADMIN IN ROBOTS.TXT
        *
        */
        $host = parse_url($given_url);
        $host = $host['scheme'] . "://" . $host['host'] . "/robots.txt";
        
        $header_check = get_headers($host);
        $response_code = $header_check[0];
        
        if(in_array($response_code, array("HTTP/1.1 200 OK", "HTTP/1.1 302 Found", "HTTP/1.0 200 OK"))) {
            $robots_content = file_get_contents($host); 
            
            $keywords = array('admin', 'administrator', 'acp', 'admincp', 'administration');
            $match = (str_replace($keywords, '', $robots_content) != $robots_content);
            if($match == 1) {
                $this->generalScore['security']['misconfiguration']['robots'] = 14.28;
            }
        }
        
        // CRAWLER STARTS RIGHT HERE
        $dom                = new DOMDocument;
        $links_to_crawl     = array($given_url);
        $inputs_vulnerable  = array();
        
        libxml_use_internal_errors(true);
        $dom->loadHTML(file_get_contents($given_url));
        libxml_clear_errors(true);
        
        foreach($dom->getElementsByTagName('a') as $node) 
        {
            if(filter_var($node->getAttribute("href"), FILTER_VALIDATE_URL) && check_if_alive($node->getAttribute("href")) && get_domain($node->getAttribute("href")) == get_domain($given_url)) {
                array_push($links_to_crawl, $node->getAttribute("href"));
            }
        }

        foreach($links_to_crawl as $another_link) {
            /*
            *
            * AUTOCOMPLETE PASSWORDS
            *
            */
            foreach($dom->getElementsByTagName('input') as $node) 
            {
                if(strlen($node->getAttribute('type')))
                {
                    $input_type = $node->getAttribute('type');
                    if($input_type == 'password')
                    {
                        if(strlen($node->getAttribute('password')))
                        {
                            $auto_complete = $node->getAttribute('autocomplete');
                            if(strcasecmp($auto_complete, 'off') != 0) {
                                array_push($inputs_vulnerable, $node->getAttribute('name') . "[onpage]" . $another_link);
                                $this->generalScore['security']['mis']['autocomplete'] = 0;
                            } else {
                                $this->generalScore['security']['mis']['autocomplete'] = 14.28;
                            }
                        }
                    }
                }
            }
            $this->generalData['security']['mis']['autocompletedesc'] = $inputs_vulnerable;

            /*
            *
            * DISCLOSURE HTTP
            *
            */
            $available_headers = array('Apache',
                                       'Win32',
                                       'mod_ssl',
                                       'OpenSSL',
                                       'PHP',
                                       'mod_perl',
                                       'Perl',
                                       'Ubuntu',
                                       'Python',
                                       'mod_python',
                                       'Microsoft',
                                       'IIS',
                                       'Unix',
                                       'Linux'
                                  );

            $powered_by        = array('PHP',
                                       'ASP',
                                       'NET',
                                       'JSP',
                                       'JBoss',
                                       'Perl',
                                       'Python'
                                  );

            @$headers = get_headers($given_url, 1);
            if($headers)
            {			
                if(isset($headers['server']))
                {
                    $current_header = $headers['server'];
                    foreach($current_header as $currentHeader)
                    {
                        if(stripos($currentHeader, $available_headers) !== false)
                        {
                            $this->generalData['security']['mis']['headersdesc'] = $currentHeader;
                            $this->generalScore['security']['mis']['headers'] = 0;
                        } else {
                            $this->generalData['security']['mis']['headersdesc'] = "OK";
                            $this->generalScore['security']['mis']['headers'] = 14.28;
                        }
                    }
                } else {
                    $this->generalData['security']['mis']['headersdesc'] = "OK";
                    $this->generalScore['security']['mis']['headers'] = 14.28;
                }

                if(isset($headers['x-powered-by']))
                {
                    $current_header = $headers['x-powered-by'];
                    foreach($current_header as $currentHeader)
                    {
                        if(stripos($currentHeader, $current_header) !== false)
                        {
                            $this->generalData['security']['mis']['powereddesc'] = $currentHeader;
                            $this->generalScore['security']['mis']['powered'] = 0;
                        } else {
                            $this->generalData['security']['mis']['powereddesc'] = "OK";
                            $this->generalScore['security']['mis']['powered'] = 14.28;
                        }
                    }
                } else {
                    $this->generalData['security']['mis']['powereddesc'] = "OK";
                    $this->generalScore['security']['mis']['powered'] = 14.28;
                }
            }
        }
    }
    
    function test_seo($given_url) {
        
        /*
        *
        * Continue Load test (because of new tab)
        *
        */
        $this->generalData['speed']['loaddesc'] = $this->session->userdata('loadtest');
        
        $loadtest_result                        = $this->generalData['speed']['loaddesc'];
        $this->generalScore['speed']['load']    = ($loadtest_result->loadTime < 3) ? 1 : 0;
        
        /*
        *
        * Continue DOM elements test (because of new tab)
        *
        */
        $this->generalData['code']['domdesc']   = $this->session->userdata('domelements');
        
        if($this->generalData['code']['domdesc'] < 1000)    $this->generalScore['code']['dom']      = 25;
        else                                                $this->generalScore['code']['dom']      = 0;
        
        self::test_seo_meta($given_url);
        self::test_seo_responsive($given_url);
    }
    
    function test_seo_meta($given_url) {
        
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $dom->loadHTML(file_get_contents($given_url));
        libxml_clear_errors(true);
        
        
        $title = $dom->getElementsByTagName("title");
        if($title->length > 0) {
            $title      = $title->item(0)->nodeValue;
                    
            // SETTING SCORE FOR META TITLE
            (strlen($title) < 70) ? $this->generalScore['seo']['meta']['title'] = 25 : $this->generalScore['seo']['meta']['title'] = 0;
            
            
            $this->generalData['seo']['meta']['titledesc']        = "Your title contains " . strlen($title) . " characters. This title's length should be under 70 characters.";
        }

        $metas          = $dom->getElementsByTagName('meta');

        $description    = "unset";
        $keywords       = "unset";
        
        if($metas) {
            for ($i = 0; $i < $metas->length; $i++)
            {
                $meta = $metas->item($i);
                if($meta->getAttribute('name') == 'description')
                    $description = $meta->getAttribute('content');
                if($meta->getAttribute('name') == 'keywords')
                    $keywords = $meta->getAttribute('content');
            }

            // SETTING SCORE FOR META DESCRIPTION
            if(strlen($description) >= 50 && strlen($description) <= 300) $this->generalScore['seo']['meta']['description']     = 25;
            else $this->generalScore['seo']['meta']['description']     = 0;
        
            // SETTING SCORE FOR KEYWORDS
            $keyword = explode(',', $keywords);
            $countKeywords = 0;
            foreach($keyword as $i =>$key) {
                $countKeywords++;
            }
            ($countKeywords <= 10) ? $this->generalScore['seo']['meta']['keywords'] = 25 : $this->generalScore['seo']['meta']['keywords'] = 25;
            
                    // SETTING DESCRIPTIONS
            $this->generalData['seo']['meta']['descriptiondesc']  = "Your description contains " . strlen($description) . " characters. This description's length should be everywhere between 50 and 300 characters.";
            $this->generalData['seo']['meta']['keywordsdesc']     = "You have " . strlen($countKeywords) . " keywords. Maximum number of keywords allowed is 10.";
        } else {
            // SETTING SCORE
            $this->generalScore['seo']['meta']['description']     = 0;
            $this->generalScore['seo']['meta']['keywords']        = 0;
            // SETTING DESCRIPTIONS
            $this->generalData['seo']['meta']['descriptiondesc']  = "Your site doesn't have a description.";
            $this->generalData['seo']['meta']['keywordsdesc']     = "Your site doesn't have any keywords.";   
        }
        
        /* CHECK OPEN GRAPH todo
        $xpath = new DOMXPath($dom);
        $query = '//*(sterge paranteza)/meta[starts-with(@property, \'og:\')]';
        $metas = $xpath->query($query);
        $rmetas = array();
        foreach ($metas as $meta) {
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            $rmetas[$property] = $content;
        }*/
    }
    
    function test_seo_responsive($given_url) {
        ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
        $responsive_ua_desktop = file_get_contents($given_url);

        ini_set('user_agent', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7');
        $responsive_ua_mobile = file_get_contents($given_url);

        similar_text(substr($responsive_ua_desktop,0,1000),substr($responsive_ua_mobile,0,1000), $similariy);


        if($similariy<50) {
            $this->generalScore['seo']['responsive'] = 1;
            $this->generalData['seo']['responsivedesc'] = "Your site behaves different on iPhone/Windows UA.";
        }
        else {
            $responsiveness             = "a";
            $responsiveness_telefon     = get_string_between($responsiveness, '<webenhancer_texttelefon>', '</webenhancer_texttelefon>');
            $responsiveness_tableta     = get_string_between($responsiveness, '<webenhancer_texttableta>', '</webenhancer_texttableta>');
            $responsiveness_pc          = get_string_between($responsiveness, '<webenhancer_textpc>', '</webenhancer_textpc>');
           
            similar_text(substr($responsiveness_telefon,0,1000),substr($responsiveness_pc,0,1000), $similarity);
            if($similariy>49) {
                $this->generalScore['seo']['responsive'] = 0;
                $this->generalData['seo']['responsivedesc'] = "Your site doesn't behave different on iPhone'/Windows UA '/ random widths.";
            } else {
                $this->generalScore['seo']['responsive'] = 25;
                $this->generalData['seo']['responsivedesc'] = "Your site behaves different on random widths.";
            }
        }
    }
    
    function loadtest() {
        $given_url              = $this->uri->segment(3);
        $data["content"]        = set_absolute_paths(file_get_contents("https://" . $given_url), $given_url);
        
        $this->load->view('webenhancer/loadtest_view', $data);
    }
    
    function get_responsiveness($given_url) {
        $data["url"]            = $given_url;
        $data["content"]        = file_get_contents($given_url);
        $data["main_content"]   = 'webenhancer/responsivetest_view';
        return $this->load->view('includes/template.php', $data);
    }
    
    function returnload() {
        if(isset($_POST["cookieset"])) {
            $this->session->set_userdata('loadtest', $_POST["cookieset"]);
            echo "200"; // bcoz return won't.
            return "200"; 
        } else {
            $this->session->set_userdata('loadtest', "501");
            echo "501"; // bcoz return won't.
            return "501"; 
        }
    }
    
    function returndomelements() {
        if(isset($_POST["domelements"])) {
            $this->session->set_userdata('domelements', $_POST["domelements"]);
            die("200"); // bcoz return won't.
        } else {
            $this->session->set_userdata('domelements', "0");
            die("501"); // bcoz return won't.
        }
    }
    
    function domelements() {
        $given_url              = $this->uri->segment(3);
        $data["content"]        = set_absolute_paths(file_get_contents("https://" . $given_url), $given_url);
        
        $this->load->view('webenhancer/domelements_view', $data);
    }

}