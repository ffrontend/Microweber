<?php
namespace mw\utils;
/**
 * @original_author    Jason Michels https://thebizztech@github.com/thebizztech/Simple-Codeigniter-Curl-PHP-Class.git
 */

class Curl
{

    public $url = "";
    public $debug = false;
    public $timeout = 60;
    private $headers = array(); //Headers are built in set_headers() and passed in execute()
    private $post_data = "";
    private $fields_string = "";
    private $log = "";
    private $log_request_response = 1;
    private $http_headers = "";

    public function __construct()
    {
        //$this->log = new \Logging\Log();
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setHttpHeaders($headers)
    {
        $this->http_headers = $headers;
        return $this;
    }

    //Headers can be modified depending on what you need cURL to accomplish

    public function get()
    {
        return $this->setHeaders()->execute();
    }

    public function execute()
    {


        if (function_exists("curl_init")) {


            $ch = curl_init();
            if (isarr($this->headers) != false) {
            }
            curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);


            curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

            if ($this->fields_string != false) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->fields_string);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // grab URL
            $result = curl_exec($ch);

            curl_close($ch);


        } else {


            $data = $this->post_data;
            if (is_array($data)) {

                $data = http_build_query($data);


                $context = stream_context_create(array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => 'Content-Type: application/x-www-form-urlencoded',
                        'content' => $data
                    )
                ));


                $result = @file_get_contents($this->url, false, $context);
            } else {
                $result = @file_get_contents($this->url, false);

            }


        }


        return $result;
    }

    //Set the headers and process curl via a GET

    private function setHeaders($type = '')
    {


        if (function_exists("curl_init")) {
            $this->headers = array(
                CURLOPT_URL => $this->url,
                CURLOPT_VERBOSE => 1,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                //CURLOPT_TIMEOUT => 30,
                CURLOPT_RETURNTRANSFER => TRUE
            );

            if ($type == 'post') {
                $this->headers[CURLOPT_POST] = TRUE;
                $this->headers[CURLOPT_POSTFIELDS] = $this->fields_string;
            }

            if (is_array($this->http_headers)) {
                $this->headers[CURLOPT_HTTPHEADER] = $this->http_headers;
                //$this->headers[CURLINFO_HEADER_OUT] = TRUE;
                //$this->headers[CURLOPT_HEADER] = 1;
                $this->headers[CURLOPT_SSL_VERIFYHOST] = FALSE;
            }
        }
        return $this;
    }

    //Set the headers and process curl via a POST

    public function post($data = false)
    {
        if (is_array($data)) {
            $this->post_data = $data;
            $this->buildPostString();
            return $this->setHeaders('post')->execute();
        } else {
            $this->fields_string = $data;
            return $this->setHeaders()->execute();
        }


    }

    //Starts curl and sets headers and returns the data in a string

    private function buildPostString()
    {

        if (function_exists("curl_init")) {
            $this->fields_string = null;
            foreach ($this->post_data as $key => $value) {
                $this->fields_string .= $key . '=' . $value . '&';
            }
            $this->fields_string = rtrim($this->fields_string, "&");


            return $this;
        }

    }
}
