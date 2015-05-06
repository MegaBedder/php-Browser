<?php
require("src/class.Browser.php");

$browser = new Browser("http://myip.se");
$browser->run();
echo $browser->get_source();