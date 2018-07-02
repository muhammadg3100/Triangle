<?php
class verify
{
    private $password = "demo";
    private $auth = false;
    public function __construct() {
        global $_triangle;

        /**
         * Login
         */
        if (isset($_GET['password'])) {
            if (is_string($_GET['password'])) {
                if ($_GET['password'] == $this->password) {
                    $this->auth = true;
    
                }
            } else {
                $_triangle->push([
                    'status' => false,
                    'message' => 'You are not authorized! directly from construct.',
                    
                    '_triangle' => [
                        'code' => 401,
    
                    ],
                ]);

            }
        }
    }
    public function get() {
        if ($this->auth) {
            return [
                'status' => true,
                'message' => 'Welcome Admin!',
    
            ];

        } else {
            return [
                'status' => false,
                'message' => 'You are not authorized!',
                
                '_triangle' => [
                    'code' => 401,

                ],
            ];

        }
    }
}
