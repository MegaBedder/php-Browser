<?php
/*
 * Copyright 2015, Ekin K. <dual@openmailbox.org>
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
    private $user_agent = "Browser/1.0 (http://github.com/iamdual/php-browser)";
    private $timeout = 10;
    private $headers = array();
    private $auto_redirect = true;
    private $auth_username = null;
    private $auth_password = null;
    private $cookie_file = null;
    private $cookie_data = null;
    private $cert_file = null;
    private $proxy_adress = null;
    private $proxy_username = null;
    private $proxy_password = null;
    private $filename = null;

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
            $this->cookie_data = (isset($defaults['cookie_data']) ? $defaults['cookie_data'] : null);
            $this->auth_username = (isset($defaults['auth_username']) ? $defaults['auth_username'] : null);
            $this->auth_password = (isset($defaults['auth_password']) ? $defaults['auth_password'] : null);
            $this->cert_file = (isset($defaults['cert_file']) ? $defaults['cert_file'] : null);
            $this->proxy_adress = (isset($defaults['proxy_adress']) ? $defaults['proxy_adress'] : null);
            $this->proxy_username = (isset($defaults['proxy_username']) ? $defaults['proxy_username'] : null);
            $this->proxy_password = (isset($defaults['proxy_password']) ? $defaults['proxy_password'] : null);
        }

        if ($this->cookie_file === null || ! is_file($this->cookie_file)) {
            $this->cookie_file = sys_get_temp_dir() . "/BrowserCookie.txt";
        }

        if ($this->cert_file === null || ! is_file($this->cert_file)) {
            $this->cert_file = dirname(__FILE__) . "/ca-bundle.crt";
        }

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

    }

    public function refferer($url) {
        $this->refferer = $url;
    }

    public function user_agent($string) {
        $this->user_agent = $string;
    }

    public function timeout($timeout) {
        $this->timeout = $timeout;
    }

    public function headers($headers) {
        $this->headers = $headers;
    }

    public function auto_redirect($option) {
        $this->auto_redirect = ($option ===  false ? $option : true);
    }

    public function auth($username = null, $password = null) {
        $this->auth_username = $username;
        $this->auth_password = $password;
    }

    public function cookie_file($filename) {
        $this->cookie_file = $filename;
    }

    public function cookie_data($data) {
        $this->cookie_data = $data;
    }

    public function cert_file($filename) {
        $this->cert_file = $filename;
    }

    public function proxy($adress, $username = null, $password = null) {
        $this->proxy_adress = $adress;
        $this->proxy_username = $username;
        $this->proxy_password = $password;
    }

    public function save_to_file($filename) {
        $this->filename = $filename;
    }

    public function post($data) {
        $this->post = $data;
    }

    public function run() {
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie_file);

        if ($this->cookie_data !== null) {
            curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie_data);
        }

        if ($this->headers !== null) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        if ($this->refferer !== null) {
            curl_setopt($this->ch, CURLOPT_REFERER, $this->refferer);
        }

        if (isset($this->proxy_adress)) {
            curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy_adress);

            if ($this->proxy_username !== null && $this->proxy_password !== null) {
                $proxy_auth = $this->proxy_username . ":" . $this->proxy_password;
                curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, $proxy_auth);
            }
        }

        if (is_file($this->cert_file)) {
            curl_setopt($this->ch, CURLOPT_CAINFO, $this->cert_file);
        }

        if ($this->auto_redirect === true) {
            curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        }

        if ($this->auth_username !== null && $this->auth_password !== null) {
            $auth = $this->auth_username . ":" . $this->auth_password;
            curl_setopt($this->ch, CURLOPT_USERPWD, $auth);
        }

        if ($this->post !== null) {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->post);
        }

        $this->source = curl_exec($this->ch);
        $this->info = curl_getinfo($this->ch);

        if ($this->filename !== null) {

            if (!file_exists(dirname($this->filename))) {
                mkdir(dirname($this->filename), 0777, true);
            }

            if (!file_exists($this->filename)) {
                touch($this->filename);
            }

            $file = fopen($this->filename, "w+");
            fputs($file, $this->source);
            fclose($file);
        }
        
        if ($this->info["http_code"] !== 200) {
            return false;
        }

        return true;
    }

    public function get_source() {
        return $this->source;
    }

    public function get_info() {
        return $this->info;
    }

    public function clear_cookie() {
        $file = fopen($this->cookie_file, "w+");
        fwrite($file , "");
        fclose($file);
    }

    function __destruct() {
        curl_close($this->ch);
    }

}
