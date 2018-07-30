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
        ini_set('max_execution_time', 400);
        
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
    
    function stop_test() {
        
        if($this->generalData['speed']['loaddesc'] != "none") {
            
            $counter                                 = 0;
            $resources                               = json_decode($this->generalData['speed']['loaddesc']);
 
            $this->generalData["speed"]["loaddesc"] = '{"resources":{';

            $total_size                             = 0;
            foreach($resources->resources as $load_data): 
                if(is_numeric(get_remote_file_size($load_data->name, false))) {
                    $total_size                    += get_remote_file_size($load_data->name, false);
                }
            endforeach;
        
            foreach($resources->resources as $load_data):
                $file_name                           = $load_data->name;
                $http_code                           = get_http_code($load_data->name);
                $domain                              = get_domain($load_data->name);
                $path_info                           = pathinfo(parse_url($load_data->name, PHP_URL_PATH), PATHINFO_EXTENSION);
                $redirect_time                       = $load_data->redirectTime;
                $dns_lookup                          = $load_data->redirectTime;
                $fetch                               = $load_data->fetchUntilResponseEnd;
                $file_size                           = get_remote_file_size($load_data->name);
                $our_grade                           = calculate_grade(
                                                        $file_size, 
                                                        $path_info, 
                                                        $redirect_time, 
                                                        $http_code
                );
                
                $this->generalData['speed']['loaddesc'] .= '"'.$counter.'":{"file_name":"'.$file_name.'","http_code":"'.$http_code.'","domain":"'.$domain.'","path_info":"'.$path_info.'","redirect_time":"'.$redirect_time.'","dns_lookup":"'.$dns_lookup.'","fetch":"'.$fetch.'","file_size":"'.$file_size.'","our_grade":"'.$our_grade.'"},';
                $counter++;
            endforeach; 
            
            $this->generalData["speed"]["loaddesc"]  = rtrim($this->generalData["speed"]["loaddesc"], ',');
            
            $this->generalData['speed']['loaddesc'] .= "}";
            
            $total_resources                    = $resources->totalResources;
            $load_time                          = $resources->domTime;
            
            $this->generalData['speed']['loaddesc'] .= ',"total_size":"'.$total_size.'","total_resources":"'.$total_resources.'","load_time":"'.$load_time.'"}';     
        }
        
        $data = json_encode(array(
            "security"=>array(
                "xssdesc"=>$this->generalData['security']['xssdesc'],
                "sqlidesc"=>$this->generalData['security']['sqlidesc'],
                "misdesc"=>array(
                    "autocompletedesc"=>$this->generalData['security']['mis']['autocompletedesc'],
                    "headersdesc"=>$this->generalData['security']['mis']['headersdesc'],
                    "powereddesc"=>$this->generalData['security']['mis']['powereddesc']
                ),
                "ssldesc"=>$this->generalData['security']['ssldesc']
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
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=".$this->session->userdata("lastTested")."&screenshot=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=utf-8'));
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $google_data = curl_exec($ch);
        curl_close($ch);

        $google_data                                = json_decode($google_data, true);
        $screenshot                                 = $google_data['screenshot']['data'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=".$this->session->userdata("lastTested")."&screenshot=true&strategy=mobile");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=utf-8'));
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $google_mobile = curl_exec($ch);
        curl_close($ch);
        
        $google_mobile                              = json_decode($google_mobile, true);
        $screenshot2                                = $google_mobile['screenshot']['data'];
        
        $this->WebEnhancer_model->insert_result(
            $this->session->userdata('lastTested'), 
            $this->input->ip_address(), 
            "0", 
            $screenshot, 
            $screenshot2,
            str_replace('"{', '{', str_replace('}"', '}',str_replace('\\/\\/', '//', str_replace('\"', '"', str_replace('\\\"', '"', $json_data))))),
            str_replace('"{', '{', str_replace('}"', '}',str_replace('\\/\\/', '//', str_replace('\"', '"', str_replace('\\\"', '"', $json_score)))))
        );
        flash_redirect('success', '', base_url("WebEnhancer/results/" . $this->db->insert_id()));
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
    
        $data["snapshot"]                           = str_replace(array('_','-'),array('/','+'),get_cached_info("Snapshot", "results", "ID", $result_id));
        $data["snapshot_mobile"]                    = str_replace(array('_','-'),array('/','+'),get_cached_info("SnapshotMobile", "results", "ID", $result_id));

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
            
        $data['totalSEO']                           = round($data["score_result"]->seo->meta->keywords + $data["score_result"]->seo->meta->title + $data["score_result"]->seo->meta->description + $data["score_result"]->seo->responsive);    
        $data['totalSpeed']                         = round($data["score_result"]->speed->minified + $data["score_result"]->speed->load);    
        $data['totalCode']                          = round($data["score_result"]->code->valid + $data["score_result"]->code->doctype + $data["score_result"]->code->encoding + $data["score_result"]->code->dom); 
        $data['totalSecurity']                      = round($data["score_result"]->security->xss + $data["score_result"]->security->sqli + $data["score_result"]->security->mis->headers + $data["score_result"]->security->mis->powered + $data["score_result"]->security->mis->autocomplete + $data["score_result"]->security->ssl); 
        
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
        
        $this->session->set_userdata("lastTested", $given_url);
        
        return $given_url;
    }
    
    function test_speed($given_url) {
        
        self::test_if_minified($given_url);
        
        $sourceUrl                              = parse_url($given_url);
        $sourceUrl                              = $sourceUrl['host'];
        
        die("<script type='text/javascript' language='Javascript'>window.open('".base_url("webenhancer/loadtest/".$sourceUrl)."')</script>");
  
    }
    
    function test_if_minified($url_content) {
        return preg_match('/^[^\n\r]+(\r\n?|\n)?$/', $url_content, $match) ? $this->generalScore['code']['minified'] = 50 : $this->generalScore['code']['minified'] = 0;
    }
    
    function test_code($given_url) {
        
        $url_content                            = file_get_contents($given_url);
        
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $dom->loadHTML($url_content);
        libxml_clear_errors(true);
        $xpath = new DOMXPath($dom);
        
        $this->generalData['code']['doctype']   = $dom->doctype->publicId;
        if(get_html_version($dom->doctype->publicId) == "HTML5") $this->generalScore['code']['doctype']  = 25;
        else $this->generalScore['code']['doctype']  = 0;
        
        
        $old_html                               = $xpath->evaluate("/html/head/meta[@http-equiv='Content-Type']/@content");
        $html5                                  = $xpath->evaluate("/html/head/meta/@charset");
        
        if(isset($html5)) {
            $this->generalData['code']['encoding']  = $html5;
            $this->generalScore['code']['encoding'] = 25;
        } elseif(isset($old_html)) {
            $this->generalData['code']['encoding']  = $old_html;
            $this->generalScore['code']['encoding'] = 25;
        } else {
            $this->generalData['code']['encoding']  = "None";
            $this->generalScore['code']['encoding'] = 0;
        }
            
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://validator.w3.org/nu/?out=json&" . http_build_query(array("doc"=>$given_url)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=utf-8'));
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // execute post
        $result = curl_exec($ch);
        curl_close($ch);
        
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
        
        $sourceUrl          = parse_url($given_url);
        $sourceUrl          = $sourceUrl['host'];
        
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
        
        $_SESSION["barabao"] = "";
        $this->generalData['security']['sqlidesc']              = "{";
        
        require_once(APPPATH.'libraries\Analyzerforms.php'); 
        require_once(APPPATH.'libraries\Analyzerinputs.php'); 
        require_once(APPPATH.'libraries\AuxClass.php'); 
        
        // VERSIUNEA 1 - INPUTURI
        $url_content = file_get_contents($given_url); 

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($url_content);
        libxml_clear_errors(true);
        
        $forms_array                                            = array();
        $input_array                                            = array();
        $textarea_array                                         = array();
        $forms_count                                            = 0;
        $sqli_syntaxes                                          = $this->config->item('sqli_syntaxes');
        $sqli_errors                                            = $this->config->item('sqli_errors');
        
        $this->generalScore["security"]["sqli"]                 = 14.28;
        
        foreach ($dom->getElementsByTagName('form') as $form)
        {
            $post_values = array();
            
            ($form->getAttribute('id') !== null)     ?      $form_id     = htmlspecialchars($form->getAttribute('id'))       : $form_id       = '';
            ($form->getAttribute('name') !== null)   ?      $form_name   = htmlspecialchars($form->getAttribute('name'))     : $form_name     = '';
            ($form->getAttribute('method') !== null) ?      $form_method = htmlspecialchars($form->getAttribute('method'))   : $form_method   = 'get';
            ($form->getAttribute('action') !== null) ?      $form_action = htmlspecialchars($form->getAttribute('action'))   : $form_action   = '';
            $form_method = strtolower($form_method);

            if (empty($form_action))
            {
                $firstIndexOfSlash = strpos($given_url, '/', strlen($given_url) - 1);
                $form_action = substr($given_url, $firstIndexOfSlash + 1, strlen($given_url));
            }

            $form_added = new Analyzerforms($form_id, $form_name, $form_method, $form_action, $forms_count);
            array_push($forms_array, $form_added);
            
            foreach ($dom->getElementsByTagName('input') as $input)
            {
                ($input->getAttribute('id') !== null)       ? $input_id      = htmlspecialchars($input->getAttribute('id'))      : $input_id = '';
                ($input->getAttribute('name') !== null)     ? $input_name    = htmlspecialchars($input->getAttribute('name'))    : $input_name = '';
                ($input->getAttribute('value') !== null)    ? $input_value   = htmlspecialchars($input->getAttribute('value'))   : $input_value = '';
                ($input->getAttribute('type') !== null)     ? $input_type    = htmlspecialchars($input->getAttribute('type'))    : $input_type = '';
                
                $input_added = new Analyzerinputs($input_id, $input_name, $form_id, $form_name, $input_value, $input_type, $forms_count);
                array_push($input_array, $input_added);
            }
            
            foreach ($dom->getElementsByTagName('textarea') as $textarea)
            {
                ($textarea->getAttribute('id') !== null)       ? $textarea_id      = htmlspecialchars($textarea->getAttribute('id'))      : $textarea_id    = '';
                ($textarea->getAttribute('name') !== null)     ? $textarea_name    = htmlspecialchars($textarea->getAttribute('name'))    : $textarea_name  = '';
                ($textarea->nodeValue !== null)                ? $textarea_value   = htmlspecialchars($textarea->nodeValue)               : $textarea_value = '';
                
                $textarea_added = new Analyzerinputs($textarea_id, $textarea_name, $form_id, $form_name, $textarea_value, "textarea", $forms_count);
                array_push($textarea_array, $textarea_added);
            }

            $forms_count++;
        }

        for ($i = 0; $i < sizeof($forms_array); $i++)
        {
            $form_current                 = $forms_array[$i];
            $form_current_id              = $form_current->getId();
            $form_current_name            = $form_current->getName();
            $form_current_method          = $form_current->getMethod();
            $form_current_action          = $form_current->getAction();
            $form_current_num             = $form_current->getFormNum();
            
            $form_current_inputs          = array();
            
            for ($j = 0; $j < sizeof($input_array); $j++)
            {
                $input_current           = $input_array[$j];
                $input_currentIdOfForm   = $input_current->getIdOfForm();
                $input_currentNameOfForm = $input_current->getNameOfForm();
                $input_currentFormNum    = $input_current->getFormNum();

                if ($form_current_num == $input_currentFormNum)
                {
                    array_push($form_current_inputs, $input_current);
                }
            }
            
            for ($j = 0; $j < sizeof($textarea_array); $j++)
            {
                $textarea_current           = $textarea_array[$j];
                $textarea_currentIdOfForm   = $textarea_current->getIdOfForm();
                $textarea_currentNameOfForm = $textarea_current->getNameOfForm();
                $textarea_currentFormNum    = $textarea_current->getFormNum();

                if ($form_current_num == $textarea_currentFormNum)
                {
                    array_push($form_current_inputs, $textarea_current); // merge them......
                }
            }
            
            for ($k = 0; $k < sizeof($form_current_inputs); $k++)
            {
                for ($sqli_counter = 0; $sqli_counter < sizeof($sqli_syntaxes); $sqli_counter++)
                {
                    $form_current_input        = $form_current_inputs[$k];
                    $form_current_input_name   = $form_current_input->getName();
                    $form_current_input_type   = $form_current_input->getType();
                    $form_current_input_value  = $form_current_input->getValue();
                    
                    if ($form_current_input_type != 'reset')
                    {
                        $arrayOfValues = array();

                        $otherInputs = array();
                        for ($l = 0; $l < sizeof($form_current_inputs); $l++)
                        {
                            if ($form_current_input->getName() != $form_current_inputs[$l]->getName())
                            {
                                array_push($otherInputs, $form_current_inputs[$l]);
                            }
                        }

                        $postObject = new AuxClass($form_current_input_name, $sqli_syntaxes[$sqli_counter]);

                        array_push($arrayOfValues, $postObject);
                        for ($m = 0; $m < sizeof($otherInputs); $m++)
                        {
                            $currentOther = $otherInputs[$m];
                            $currentOtherType = $currentOther->getType();
                            $currentOtherName = $currentOther->getName();
                            $currentOtherValue = $currentOther->getValue();
                            if ($currentOtherType == 'textarea') {
                                $postObject = new AuxClass($currentOtherName, $sqli_syntaxes[$sqli_counter]);
                                array_push($arrayOfValues, $postObject);
                            }
                            else if ($currentOtherType == 'text' || $currentOtherType == 'password')
                            {
                                $postObject = new AuxClass($currentOtherName, 'oPtImaL123??Leng');
                                array_push($arrayOfValues, $postObject);
                            }
                            else
                            if ($currentOtherType == 'checkbox' || $currentOtherType == 'submit')
                            {
                                $postObject = new AuxClass($currentOtherName, $currentOtherValue);
                                array_push($arrayOfValues, $postObject);
                            }
                            else
                            if ($currentOtherType == 'radio')
                            {
                                $postObject = new AuxClass($currentOtherName, $currentOtherValue);

                                $found = false;
                                for ($n = 0; $n < sizeof($arrayOfValues); $n++)
                                {
                                    if ($arrayOfValues[$n]->getName() == $postObject->getName())
                                    {
                                        $found = true;
                                        break;
                                    }
                                }

                                if (!$found) array_push($arrayOfValues, $postObject);
                            }
                        }
                        if ($form_current_method == 'post')
                        {
                    
                            if ($given_url[strlen($given_url) - 1] == '/') $actionUrl = $given_url . $form_current_action;
                            else $actionUrl = $given_url . '/' . $form_current_action;
                            
                            for ($p = 0; $p < sizeof($arrayOfValues); $p++)
                            {
                                $currentPostValue = $arrayOfValues[$p];
                                $currentPostValueName = $currentPostValue->getName();
                                $currentPostValueValue = $currentPostValue->getValue();
                                $tempArray = array(
                                    $currentPostValueName => $currentPostValueValue
                                );
                                $post_values = array_merge($post_values, $tempArray);
                            }

                            $ch = curl_init();
                            
                            // set the url, number of POST vars, POST data
                            curl_setopt($ch, CURLOPT_URL, $actionUrl);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_values));
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

                            // execute post
                            $result = curl_exec($ch);

                            curl_close($ch);

                            $vulnerabilityFound = false;
                            for ($warningIndex = 0; $warningIndex < sizeof($sqli_errors); $warningIndex++)
                            {
                                $regularExpression = "/$sqli_errors[$warningIndex]/";
                                if (preg_match($regularExpression, $result))
                                {
                                    $vulnerabilityFound = true;
                                    break;
                                }
                            }

                            if ($vulnerabilityFound)
                            {
                                
                                $totalTestStr = ''; 
                                for ($p = 0; $p < sizeof($arrayOfValues); $p++)
                                {
                                    $currentPostValue = $arrayOfValues[$p];
                                    $currentPostValueName = $currentPostValue->getName();
                                    $currentPostValueValue = $currentPostValue->getValue();
                                    $totalTestStr.= $currentPostValueName;
                                    $totalTestStr.= '=';
                                    $totalTestStr.= $currentPostValueValue;
                                    if ($p != (sizeof($arrayOfValues) - 1)) $totalTestStr.= '&';
                                }

                                $form_current_method = strtolower($form_current_method);

                                $this->generalScore["security"]["sqli"]                                = 0;

                                $this->generalData['security']['sqlidesc']                            .= '"'.$k.'":{"query":"'.htmlspecialchars(htmlentities($totalTestStr)).'","url":"'.htmlspecialchars(htmlentities($actionUrl)).'","method":"'.$form_current_method.'","error":"'.$regularExpression.'"},';
                                break;
                            } else {
                                $this->generalScore["security"]["sqli"]                                 = 14.28;
                            }
                        }
                    }
                }
            }
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
        
        
        
        $this->generalData['security']['sqlidesc']  = rtrim($this->generalData['security']['sqlidesc'], ',');
        $this->generalData['security']['sqlidesc'] .= "}";
    }
    
     // TEST SECURITY AUDIT: XSS
    function test_audit_xss($given_url) {
        
        
        // VERSIUNEA 1 - PARAMETRI - SELF XSS
        @$parsed_url  = parse_url($given_url); // suppress bcoz i got no time left!!!!
        
        $xss_syntaxes     = array(
            '"><script%20data-cfasync=false>alert(/webenhancer/)</script>',
            //'<scrscriptipt>document.write("webenhancerteststring")</scrscriptipt>',
            '<marquee><script%20data-cfasync=false>alert(/webenhancer/)</script></marquee>',
            '<script%20data-cfasync=false>alert(String.fromCharCode(88,83,83));))"></script>',
            '<img src=x onerror="&#0000106&#0000097&#0000118&#0000097&#0000115&#0000099&#0000114&#0000105&#0000112&#0000116&#0000058&#0000097&#0000108&#0000101&#0000114&#0000116&#0000040&#0000039&#0000088&#0000083&#0000083&#0000039&#0000041">',
            '<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29>'
        );
        
        if ($parsed_url)
        {
            if (isset($parsed_url['query']))
            {
                $scheme                                                                             = $parsed_url['scheme'];
                $host                                                                               = $parsed_url['host'];
                $path                                                                               = $parsed_url['path'];
                $query                                                                              = $parsed_url['query'];
                parse_str($query, $parameters);
                $original_query                                                                     = $query;
                $syntax_counter                                                                     = 0;
                $this->generalData['security']['xssdesc']                                           = '{';
                foreach($xss_syntaxes as $current_xss)
                {
                    
                    foreach($parameters as $para)
                    {
                        $query          = $original_query;
                        $new_query      = str_replace($para, $current_xss, $query);
                        $query          = $new_query;
                        $testUrl        = $scheme . '://' . $host . $path . '?' . $query;
                        
                        $retrieved_data = get_data($testUrl);
                        
                        if (stripos($retrieved_data, urldecode($xss_syntaxes[$syntax_counter])))
                        {   
                            $this->generalData['security']['xssdesc']                              .= '"'.$syntax_counter.'":{"query":"'.htmlspecialchars(htmlentities($xss_syntaxes[$syntax_counter])).'","url":"'.htmlspecialchars(htmlentities($testUrl)).'","method":"GET"},';
                        }
                    }

                    $syntax_counter++;
                }
                
                $this->generalData['security']['xssdesc']                                          = rtrim($this->generalData['security']['xssdesc'], ',');
                $this->generalData['security']['xssdesc']                                          .= '}';
            }
        }
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
                            if(!strcasecmp($auto_complete, 'off')) {
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
        self::test_seo_meta($given_url);
        self::test_seo_responsive($given_url);
    }
    
    function test_seo_meta($given_url) {
        
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        $dom->loadHTML(file_get_contents($given_url));
        libxml_clear_errors(true);
        $xpath = new DOMXPath($dom);
    
        $title          = $xpath->evaluate('string(//head/title)');
        $description    = $xpath->evaluate('string(//meta[@name="description"]/@content)');
        $keywords       = $xpath->evaluate('string(//meta[@name="keywords"]/@content)');
        
        
        if(isset($title)) {
            (strlen($title) < 70) ? $this->generalScore['seo']['meta']['title'] = 25 : $this->generalScore['seo']['meta']['title'] = 0;
            $this->generalData['seo']['meta']['titledesc']        = "Your title contains " . strlen($title) . " characters. This title's length should be under 70 characters.";
        } else {
            $this->generalScore['seo']['meta']['title'] = 0;
            $this->generalData['seo']['meta']['titledesc']        = "Your site doesn't have a title.";
        }

        $metas          = $dom->getElementsByTagName('meta');
        
        if(isset($description)) {
            if(strlen($description) >= 50 && strlen($description) <= 300) $this->generalScore['seo']['meta']['description']     = 25;
            else $this->generalScore['seo']['meta']['description']     = 0;
            
            $this->generalData['seo']['meta']['descriptiondesc']  = "Your description contains " . strlen($description) . " characters. This description's length should be everywhere between 50 and 300 characters.";
        } else {
            $this->generalScore['seo']['meta']['description']     = 0;
            $this->generalData['seo']['meta']['descriptiondesc']  = "Your site doesn't have a description.";
            $description = "";
        }
        
        if(isset($keywords)) {
            $keyword = explode(',', $keywords);
            $countKeywords = 0;
            foreach($keyword as $i =>$key) {
                $countKeywords++;
            }
            ($countKeywords <= 10) ? $this->generalScore['seo']['meta']['keywords'] = 25 : $this->generalScore['seo']['meta']['keywords'] = 25;
            $this->generalData['seo']['meta']['keywordsdesc']     = "You have " . strlen($countKeywords) . " keywords. Maximum number of keywords allowed is 10.";
        } else {
            $keywords = "";
            $this->generalScore['seo']['meta']['keywords']        = 0;
            $this->generalData['seo']['meta']['keywordsdesc']     = "Your site doesn't have any keywords.";   
        }
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
    
    function continue_test() {
        $source_url = $this->uri->segment(3);

        $given_url = $this->session->userdata('lastTested');
        
        
        $this->generalData['speed']['loaddesc'] = ($this->session->userdata('loadtest') != null) ? $this->session->userdata('loadtest') : "none" ;
        
        $loadtest_result                        = $this->generalData['speed']['loaddesc'];
        $decoded_json                           = json_decode($loadtest_result);

        $this->generalScore['speed']['load']    = ($decoded_json->domTime < 3) ? 50 : 0;
        
        
        /*
        *
        * Continue DOM elements test (because of new tab)
        *
        */
        $this->generalData['code']['domdesc']               = ($this->session->userdata('domelements') != null) ? $this->session->userdata('domelements') : "none" ;
        
        if($this->generalData['code']['domdesc'] < 1000)    $this->generalScore['code']['dom']      = 25;
        else                                                $this->generalScore['code']['dom']      = 0;

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

        // DELETE SCRIPTS
        for ($member_count = $dom->getElementsByTagName("script")->length; --$member_count >= 0; ) {
            $node = $dom->getElementsByTagName("script")->item($member_count);
            $node->parentNode->removeChild($node);
        }
        $content = $dom->saveHtml();
        
        // TESTUL 2 - CODE VALIDATOR
        self::test_code($given_url);
        
        // TESTUL 3 - SEO HELPER
        self::test_seo($given_url);
        
        // TESTUL 4 - AUDIT SECURITATE
        self::test_audit($given_url);
        
        self::stop_test();
    }
    
    function loadtest() {
        $data["given_url"]      = $this->uri->segment(3);
        $data["full_url"]       = $this->session->userdata("lastTested");
        $data["content"]        = set_absolute_paths(file_get_contents("https://" . $data["given_url"]), $data["given_url"]);
        
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
            $this->session->set_userdata('domelements', $_POST["domelements"]);
            echo "200"; // bcoz return won't.
            return "200"; 
        } else {
            $this->session->set_userdata('domelements', "0");
            $this->session->set_userdata('loadtest', "501");
            echo "501"; // bcoz return won't.
            return "501"; 
        }
    }
    
    function domelements() {
        $data["given_url"]      = $this->uri->segment(3);
        $data["content"]        = set_absolute_paths(file_get_contents("https://" . $data["given_url"]), $data["given_url"]);
        
        $this->load->view('webenhancer/domelements_view', $data);
    }

}