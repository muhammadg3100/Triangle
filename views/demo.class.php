<?php
/**
 * Its will run as:
 * http://host/demo
 * 
 */
class demo {
    /**
     * Method: GET
     */
    public function get() {
        return [
            'status' => true,
            'message' => 'Hello World!',
            'get' => $_GET,

        ];

    }
    
    /**
     * Method: POST
     */
    public function post() {
        return [
            'status' => true,
            'message' => 'Hello World!',
            'post' => $_POST,

        ];

    }
}