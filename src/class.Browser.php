<?php
/*
 * Copyright 2014, Ekin K. <dual@openmailbox.org>
 *
 * Documentation:
 * https://github.com/iamdual/php-browser
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Browser {

    private $ch = null;
    private $post = null;
    private $source = null;
    private $info = null;
    private $refferer = null;
    private $user_agent = "Browser/0.1 (http://github.com/iamdual/php-browser)";
    private $timeout = 10;
    private $headers = array();
    private $auto_redirect = true;
    private $cookie_file = null;
    private $cookie = null;
    private $cert_file = null;
    private $save_to_file = null;

    function __construct($url, $defaults = null) {

        if(!is_callable('curl_init')){
            echo "cURL is not found. Please install PHP cURL library. More: http://php.net/manual/en/book.curl.php";
            exit;
        }

        if ($defaults !== null) {
            $this->refferer = (isset($defaults['refferer']) ? $defaults['refferer'] : null);
            $this->user_agent = (isset($defaults['user_agent']) ? $defaults['user_agent'] : null);
            $this->timeout = (isset($defaults['timeout']) ? $defaults['timeout'] : null);
            $this->headers = (isset($defaults['headers']) ? $defaults['headers'] : null);
            $this->cookie_file = (isset($defaults['cookie_file']) ? $defaults['cookie_file'] : null);
            $this->cookie = (isset($defaults['cookie']) ? $defaults['cookie'] : null);
            $this->cert_file = (isset($defaults['cert_file']) ? $defaults['cert_file'] : null);
        }

        if ($this->cookie_file === null) {
            $this->cookie_file = sys_get_temp_dir() . "/Browser.tmp";
        }

        if ($this->cert_file === null) {
            $this->cert_file = dirname(__FILE__) . "/ca-bundle.crt";
        }

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

    }

    public function set_refferer($refferer_url) {
        $this->refferer = $refferer_url;
    }

    public function set_user_agent($user_agent) {
        $this->user_agent = $user_agent;
    }

    public function set_timeout($timeout) {
        $this->timeout = $timeout;
    }

    public function set_headers($headers) {
        $this->headers = $headers;
    }

    public function auto_redirect($option) {
        $this->auto_redirect = ($option ===  false ? $option : true);
    }

    public function cookie_file($filename) {
        $this->cookie_file = $filename;
    }

    public function set_cookie($cookie) {
        $this->cookie = $cookie;
    }

    public function cert_file($filename) {
        $this->cert_file = $filename;
    }

    public function save_to_file($filename) {
        $this->save_to_file = $filename;
    }

    public function post($data) {
        $this->post = $data;
    }

    public function run() {
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie_file);

        if ($this->refferer !== null) {
            curl_setopt($this->ch, CURLOPT_REFERER, $this->refferer);
        }

        if ($this->headers !== null) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        if ($this->cookie !== null) {
            curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
        }

        if (is_file($this->cert_file)) {
            curl_setopt($this->ch, CURLOPT_CAINFO, $this->cert_file);
        }

        if ($this->post !== null) {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->post);
        }

        if ($this->auto_redirect === true) {
            curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        }

        $this->source = curl_exec($this->ch);
        $this->info = curl_getinfo($this->ch);

        if ($this->save_to_file !== null) {

            if (!file_exists(dirname($this->save_to_file))) {
                mkdir(dirname($this->save_to_file), 0777, true);
            }

            if (!file_exists($this->save_to_file)) {
                touch($this->save_to_file);
            }

            $file = fopen($this->save_to_file, "w+");
            fputs($file, $this->source);
            fclose($file);
        }
    }

    public function get_source() {
        return $this->source;
    }

    public function get_info() {
        return $this->info;
    }

    public function clear_cookie() {
        return @unlink($this->cookie_file);
    }

    function __destruct() {
        curl_close($this->ch);
    }

}