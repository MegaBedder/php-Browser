<?php
require("src/class.Browser.php");


// Get Page Source

$browser = new Browser("https://www.google.com");
$browser->run();
echo $browser->get_source();


// Get Page Source with Defaults

$defaults = array(
    'refferer' => 'https://www.google.com',
    'useragent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
    'timeout' => 20,
    'cookie_file' => 'cookie.txt'
);
$browser = new Browser("http://example.dev/login.php", $defaults);
$browser->post("username=admin&password=example");
$browser->run();
$browser = new Browser("http://example.dev/search.php", $defaults);
$browser->run();
echo $browser->get_source();


// Download File to Folder

$browser = new Browser("https://www.google.com.tr/images/srpr/logo11w.png");
$browser->save_to_file("files/logo.png");
$browser->run();