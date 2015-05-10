<?php
set_time_limit(0);

require("../src/class.Browser.php");


$browser = new Browser("https://www.google.com");
$browser->save_to_file("test/test/index.html");
$browser->run();
echo $browser->get_source();