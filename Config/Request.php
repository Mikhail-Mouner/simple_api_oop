<?php
namespace Config;

class Request
{
    public $request ;
    public $method  ;
    
    public function __construct($method = 'POST') {
        $this->method = strtolower($method);
        
        parse_str(file_get_contents("php://input"),$request);
        switch ($method) {
            case 'POST':
                $this->request['post'] = $request;
            break;
            
            case 'PUT':
                $this->request['put'] = $request;
                break;
            
            default:
                break;
        }
        
    }

    public function __get($var)
    {
        If (isset($this->request[$this->method])) 
            return $this->request[$this->method][$var];
        return NULL;
    }

}
