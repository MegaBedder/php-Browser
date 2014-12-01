<?php
require("src/class.Browser.php");


// Get Page Source

$browser = new Browser("https://www.google.com");
$browser->run();
# echo $browser->get_source();


// Get Page Source & Using Defaults

$defaults = array(
    'refferer' => 'https://www.google.com',
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
    'timeout' => 20,
    'cookie_file' => 'cookie.txt'
);

$browser = new Browser("http://example.dev/login.php", $defaults);
$browser->post("username=admin&password=example");
$browser->run();
$browser = new Browser("http://example.dev/search.php", $defaults);
$browser->run();
# echo $browser->get_source();


// Download File

$browser = new Browser("https://www.google.com.tr/images/srpr/logo11w.png");
$browser->save_to_file("files/logo.png");
$browser->run();


// Custom Headers

$headers = array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic '. base64_encode("username:password")
);

$browser = new Browser("http://example.dev/index.php");
$browser->set_headers($headers);
$browser->run();
# echo $browser->get_source();


// Set Custom User Agent

$browser = new Browser("https://www.google.com");
$browser->set_user_agent("Example User Agent");
$browser->run();
# echo $browser->get_source();


// Set Custom Timeout

$browser = new Browser("https://www.google.com");
$browser->set_timeout(1);
$browser->run();
# echo $browser->get_source();