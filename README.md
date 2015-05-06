php-Browser
=============

Featured and simple HTTP request class.

#### Requirements

- PHP 5.3+
- PHP Curl library

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
| `set_refferer($url = null)` | Set refferer url. |
| `set_user_agent($string = "Browser/0.1...")` | Set user agent string. |
| `set_timeout($timeout = 10)` | Set timeout. |
| `set_headers($headers = array())` | Set headers with array. |
| `set_auto_redirect($option = true)` | Set auto redirect option. |
| `set_cookie_file($filename = "/tmp/Browser.tmp")` | Set cookie file. |
| `set_cookie_data($data = "PHPSESSID=1a2b3c4d5e6f7g8h; COLOR=Pink")` | Set cookie data. |
| `set_cert_file($filename = "ca-bundle.crt")` | Set bundle of cert file. |
| `set_proxy($adress = null, $username = null, $password = null)` | Set proxy. |
| `post($data = null)` | Post data. |
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
    'cookie_file' => '/example/path/BrowserCookie.txt',
    'cookie' => 'PHPSESSID=1a2b3c4d5e6f7g8h; BROWSER=Firefox; COLOR=Pink'
    'cert_file' => '/example/path/ca-bundle.crt',
    'headers' => array('Content-Type: application/x-www-form-urlencoded', 'Foo: Bar'),
    'proxy_adress' => '1.2.3.4:8080',
    'proxy_username' => null,
    'proxy_password' => null
);

$browser = new Browser("https://example.dev/login.php", $defaults);

[...]
```
