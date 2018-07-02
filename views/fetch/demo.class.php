<?php
/**
 * Its will run as:
 * http://host/fetch/demo
 * 
 */
class demo {
    /**
     * Method: GET
     */
    public function get() {
        return [
            'status' => true,
            'message' => 'Hello World! What do you want to fetch today!?',
            'get' => $_GET,

        ];

    }
}