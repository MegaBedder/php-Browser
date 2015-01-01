php-Browser
=============

Featured and simple HTTP request class.

#### Using

```php
require("class.Browser.php");

$browser = new Browser("http://example.dev/login.php");
$browser->post("username=admin&password=example");
$browser->run();
$browser = new Browser("http://example.dev/myaccount.php");
$browser->run();
echo $browser->get_source();
```

#### Methods

| Name & Defaults | Description | 
| ----------- | ----------- |
| `set_refferer($refferer_url = null)` | Set refferer url. |
| `set_user_agent($useragent = "Browser/0.1...")` | Set user agent. |
| `set_timeout($timeout = 10)` | Set timeout. |
| `set_headers($headers = array())` | Set headers with array. |
| `auto_redirect($option = true)` | Auto redirect option. |
| `cookie_file($filename = "/tmp/Browser.tmp")` | Cookie file. |
| `set_cookie($cookie = "PHPSESSID=1a2b3c4d5e6f7g8h; COLOR=Pink")` | Cookie string. |
| `cert_file($filename = "ca-bundle.crt")` | Bundle of certificates file. |
| `post($data = null)` | Set post data. |
| `save_to_file($filename = null)` | Save data to file. |
| `run()` | Run HTTP request. |
| `get_source()` | Get request source code. |
| `get_info()` | Get request info in array(). |
| `clear_cookie()` | Clear cookie file. |

#### Set defaults

```php
require("class.Browser.php");

$defaults = array(
    'refferer' => 'https://www.google.com', 
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
    'timeout' => 20, 
    'cookie_file' => 'cookie.txt',
    'cookie' => 'PHPSESSID=1a2b3c4d5e6f7g8h; BROWSER=Firefox; COLOR=Pink'
    'cert_file' => '/example/path/ca-bundle.crt',
    'headers' => array('Content-Type: application/x-www-form-urlencoded', 'Foo: Bar')
);

$browser = new Browser("https://example.dev/login.php", $defaults);

[...]
```
