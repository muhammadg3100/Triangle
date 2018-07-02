<?php
/**
 * @author Muhammad Gholy <muhammadg3100@gmail.com>
 * @license MIT
 * @package triangle
 */
final class Triangle
{
    /**
     * User Configuration
     * 
     * @var array
     */
    public $config;

    /**
     * Class Configuration
     * 
     * @var array
     */
    private $_config = [
        'code' => array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing', // WebDAV; RFC 2518
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information', // since HTTP/1.1
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status', // WebDAV; RFC 4918
            208 => 'Already Reported', // WebDAV; RFC 5842
            226 => 'IM Used', // RFC 3229
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other', // since HTTP/1.1
            304 => 'Not Modified',
            305 => 'Use Proxy', // since HTTP/1.1
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect', // since HTTP/1.1
            308 => 'Permanent Redirect', // approved as experimental RFC
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot', // RFC 2324
            419 => 'Authentication Timeout', // not in RFC 2616
            420 => 'Enhance Your Calm', // Twitter
            420 => 'Method Failure', // Spring Framework
            422 => 'Unprocessable Entity', // WebDAV; RFC 4918
            423 => 'Locked', // WebDAV; RFC 4918
            424 => 'Failed Dependency', // WebDAV; RFC 4918
            424 => 'Method Failure', // WebDAV)
            425 => 'Unordered Collection', // Internet draft
            426 => 'Upgrade Required', // RFC 2817
            428 => 'Precondition Required', // RFC 6585
            429 => 'Too Many Requests', // RFC 6585
            431 => 'Request Header Fields Too Large', // RFC 6585
            444 => 'No Response', // Nginx
            449 => 'Retry With', // Microsoft
            450 => 'Blocked by Windows Parental Controls', // Microsoft
            451 => 'Redirect', // Microsoft
            451 => 'Unavailable For Legal Reasons', // Internet draft
            494 => 'Request Header Too Large', // Nginx
            495 => 'Cert Error', // Nginx
            496 => 'No Cert', // Nginx
            497 => 'HTTP to HTTPS', // Nginx
            499 => 'Client Closed Request', // Nginx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates', // RFC 2295
            507 => 'Insufficient Storage', // WebDAV; RFC 4918
            508 => 'Loop Detected', // WebDAV; RFC 5842
            509 => 'Bandwidth Limit Exceeded', // Apache bw/limited extension
            510 => 'Not Extended', // RFC 2774
            511 => 'Network Authentication Required', // RFC 6585
            598 => 'Network read timeout error', // Unknown
            599 => 'Network connect timeout error', // Unknown
        ),

    ];

    public function strposa(&$a, $b) {
        foreach ($a as $c) if ($c == $b) return true;
        return false;

    }
    public function __construct($config = []) {
        global $_triangle;

        /**
         * Misc
         */
        set_exception_handler(array($this, 'customExceptionHandler'));
        set_error_handler(array($this, 'customErrorHandler'),E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
        $this->config = $config;
        $_triangle = $this;

        if ($this->config['respond']['type'] == "auto") {
            if (isset($_SERVER['HTTP_ACCEPT'])) {
                if (strpos($_SERVER['HTTP_ACCEPT'], '/json') !== false) {
                    $this->_config['respond'] = 'JSON';

                } else if (strpos($_SERVER['HTTP_ACCEPT'], '/xml') !== false) {
                    $this->_config['respond'] = 'XML';
                    
                } else {
                    $this->_config['respond'] = null;
                    $this->push($this->config['error'][406](['code' => '/x/construct/2465']));

                }

            } else {
                $this->_config['respond'] = null;
                $this->push($this->config['error'][406](['code' => '/x/construct/1543']));

            }
        
        } else {
            $this->_config['respond'] = $this->config['respond']['type'];

        }

        if (isset($this->config['response']['type'])) {
            $this->setResponse($this->config['response']['type']);

        } else {
            $this->push($this->config['error'][501](['code' => '/x/construct/5915']));

        }

        if (isset($_SERVER['REQUEST_METHOD'])) {
            if (!$this->strposa($this->config['method'], $_SERVER['REQUEST_METHOD'])) {
                $this->push($this->config['error'][405](['code' => '/x/construct/3256']));

            }
             
        } else {
            $this->push($this->config['error'][405](['code' => '/x/construct/5476']));

        }

        $this->_config['uri'] = urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)

        );

        $path = dirname(__FILE__) . '/../views';
        $filename = substr($this->_config['uri'], 1, strlen($this->_config['uri']));
        if (strpos($filename, '/') !== false) {
            $filename = explode('/', $filename);
            foreach ($filename as $key => $value) {
                if ($value == ".." || $value == ".") continue;
                if ($key == count($filename)-1) {
                    $filename = $value;
                    
                } else {
                    if (file_exists($path . '/' . $value)) {
                        $path .= '/' . $value;
    
                    }
                }
            }

        }

        $filepath = $path . '/' . $filename . '.class.php';
        if (file_exists($filepath)) {
            require $filepath;
            if (class_exists($filename)) {
                $_tmp = new $filename();
                $_tmp2 = strtolower($_SERVER['REQUEST_METHOD']);
                if (method_exists($_tmp, $_tmp2)) {
                    $this->push($_tmp->$_tmp2());

                } else {
                    $this->push($this->config['error'][501](['code' => '/x/construct/3464']));
                    
                }

            } else {
                $this->push($this->config['error'][501](['code' => '/x/construct/8212']));

            }

        } else {
            $this->push($this->config['error'][404](['code' => '/x/construct/2654']));

        }
    }
	public function customErrorHandler($errno, $errstr, $errfile, $errline) {
        $this->push($this->config['error'][500](['code' => $errno, 'message' => $errstr, 'line' => $errline, 'file' => $errfile]));
        
	}
	public function customExceptionHandler($e) {
        $this->push($this->config['error'][500](['code' => '/x/exception', 'message' => $e->getMessage()]));
        
	}
    public function setResponse($a) {
        if (strtolower($a) == "json") {
            $this->_config['response'] = "JSON";
            if (isset($_SERVER['CONTENT_TYPE'])) {
                if (strpos(strtolower($_SERVER['CONTENT_TYPE']), '/json') !== false) {
                    $_POST = json_decode(file_get_contents('php://input'), true);

                } else {
                    $this->push($this->config['error'][415](['code' => '/x/setResponse/7985']));

                }
            } else {
                $this->push($this->config['error'][415](['code' => '/x/setResponse/1234']));

            }

        } elseif (strtolower($a) == "post") {
            $this->_config['response'] = "POST";

        } elseif (strtolower($a) == "xml") {
            $this->_config['response'] = "XML";
            if (isset($_SERVER['CONTENT_TYPE'])) {
                if (strpos(strtolower($_SERVER['CONTENT_TYPE']), '/xml') !== false) {
                    /**
                     * Json Encode, Then Json Decode isn't too GOOD!
                     * Fix ASAP
                     */
                    $_POST = json_decode(json_encode(simplexml_load_string(file_get_contents("php://input"))), true);
                    
                } else {
                    $this->push($this->config['error'][415](['code' => '/x/setResponse/2343']));

                }
            } else {
                $this->push($this->config['error'][415](['code' => '/x/setResponse/3253']));

            }

        } elseif (strtolower($a) == "auto") {
            if (isset($_SERVER['CONTENT_TYPE'])) {
                if (strpos($_SERVER['CONTENT_TYPE'], '/json') !== false) {
                    return $this->setResponse('json');

                } else if (strpos($_SERVER['CONTENT_TYPE'], '/xml') !== false) {
                        return $this->setResponse('xml');
    
                } else if (strpos($_SERVER['CONTENT_TYPE'], '/form-data') !== false || strpos($_SERVER['CONTENT_TYPE'], '/x-www-form-urlencoded') !== false || empty($_SERVER['CONTENT_TYPE'])) {
                    return $this->setResponse('post');
                    
                } else {
                    $this->push($this->config['error'][415](['code' => '/x/setResponse/6543']));

                }

            } else {
                $this->_config['response'] = 'POST';

            }

        } else {
            $this->push($this->config['error'][415](['code' => '/x/setResponse/3564']));

        }
        return $this;

    }
    public function xml($array = [], $parent = "root", $root = false) {
        $data = "";
        if ($root) $data .= '<?xml version="1.0"?><'.$parent.'>';
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $data .= '<'.$key.'>'.$value.'</'.$key.'>';

            } else if (is_bool($value)) {
                $data .= '<'.$key.'>'.($value ? 'true': 'false').'</'.$key.'>';
                
            } else if (is_null($value)) {
                $data .= '<'.$key.'>null</'.$key.'>';
                
            } else if (is_array($value)) {
                $data .= '<'.$key.'>'.$this->xml($value).'</'.$key.'>';
                
            } else {
                $data .= '<'.$key.'>'. (string) $value .'</'.$key.'>';
                
            }
        }
        if ($root) $data .= '</'.$parent.'>';
        return $data;

    }
    public function push($a) {
        $data = [];
        if (is_callable($a)) {
            $data = $a();

        } else {
            $data = $a;

        }
        if (!is_array($data)) {
            $data = $this->config['error'][500](['code' => '/x/push/1422']);

        }
        

        if (isset($data['_triangle']['code'])) {
            if (function_exists('http_response_code')) {
                if (!http_response_code($data['_triangle']['code'])) {
                    if (isset($this->_config['code'][$data['_triangle']['code']])) {
                        header(trim("HTTP/{$this->config['http']['version']} {$code} {$reason}"));
        
                    } else {
                        header(trim("HTTP/{$this->config['http']['version']} {$code} Unknown"));
    
                    }
                }

            } else {
                if (isset($this->_config['code'][$data['_triangle']['code']])) {
                    header(trim("HTTP/{$this->config['http']['version']} {$code} {$reason}"));
    
                } else {
                    header(trim("HTTP/{$this->config['http']['version']} {$code} Unknown"));

                }

            }
        }

        if (isset($data['_triangle']['header'])) {
            if (is_array($data['_triangle']['header'])) {
                foreach ($data['_triangle']['header'] as $key => $value) {
                    if (is_string($value) && is_string($key)) {
                        header($key.": ".$value);

                    }
                }
            }
        }

        // Done.
        unset($data['_triangle']);
        switch (strtolower($this->_config['respond'])) {
            case 'xml':
                header("Content-Type: text/xml");
                die($this->xml($data, $this->config['respond']['configuration']['xml']['root'], true));
            
            default:
                header("Content-Type: application/json");
                die(json_encode($data));

        }
    }
}