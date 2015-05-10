php-Browser
=============

Featured and simple HTTP request class.

#### Requirements

- PHP 5.3+
- PHP cURL library

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
| `refferer($url)` | Set refferer url. |
| `user_agent($string = "Browser/0.1...")` | Set user agent string. |
| `timeout($timeout = 10)` | Set timeout. |
| `headers($headers = array())` | Set headers with array. |
| `auto_redirect($option = true)` | Set auto redirect option. |
| `cookie_file($filename = "/tmp/BrowserCookie.txt")` | Set cookie file. |
| `cookie_data($data)` | Set cookie data. |
| `auth($username = null, $password = null)` | Set authorizing info. |
| `cert_file($filename = "/src/ca-bundle.crt")` | Set bundle of cert file. |
| `proxy($adress, $username = null, $password = null)` | Set proxy. |
| `post($data)` | Set post data. |
| `save_to_file($filename)` | Save data to file. |
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
    'cookie_data' => 'PHPSESSID=1a2b3c4d5e6f7g8h; BROWSER=Firefox; COLOR=Pink'
    'auth_username' => null,
    'auth_password' => null,
    'cert_file' => '/example/path/ca-bundle.crt',
    'headers' => array('Content-Type: application/x-www-form-urlencoded', 'Foo: Bar'),
    'proxy_adress' => '1.2.3.4:8080',
    'proxy_username' => null,
    'proxy_password' => null
);

$browser = new Browser("https://example.dev/login.php", $defaults);

[...]
```