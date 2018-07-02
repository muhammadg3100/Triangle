<?php
/**
 * Its will run as:
 * http://host/fetch/fetch/demo
 * 
 */
class demo {
    /**
     * Method: GET
     */
    public function get() {
        return [
            'status' => true,
            'message' => 'Hello World! What do you want to fetch fetch today!?',
            'get' => $_GET,

        ];

    }
}