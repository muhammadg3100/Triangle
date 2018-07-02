<?php
/**
 * Main class of Triangle
 * Load all code needed.
 */
require_once dirname(__FILE__) . "/lib/main.class.php";

/**
 * Start Triangle
 */
($_triangle = new Triangle([
    /**
     * What does client exptect !?!?!?
     * AUTO / JSON / XML
     * 
     */
    'respond' => [
        'type' => 'auto',
        'configuration' => [
            'xml' => [
                'root' => 'root'
                
            ]
        ],
    ],
    
    /**
     * Choose the server needle.
     * AUTO, JSON / POST / XML
     * 
     */
    'response' => [
        'type' => 'auto',
        'configuration' => [
            'xml' => [
                'root' => 'root',

                /**
                 * TODO!
                 */
                'parser' => [
                    'LIBXML_NOCDATA',
                    'LIBXML_NOBLANKS'
                ],
            ]
        ],
    ],

    /**
     * What method do we allow
     * 
     */
    'method' => [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'PATCH'
    ],

    /**
     * Misc
     * 
     */
    'http' => [
        'version' => 1.0
        
    ],

    /**
     * Just a default respond for the main.class.php to throw an error!
     * 
     */
    'error' => [
        404 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Not Found',
                'details' => $a,
                
                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 404,
                    
                ],
            ];

        },
        405 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Method Not Allowed',
                'details' => $a,
                
                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 405,
                    
                ],
            ];

        },
        406 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Not Acceptable',
                'details' => $a,
                
                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 406,
                    
                ],
            ];

        },
        415 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Unsupported Media Type',
                'details' => $a,
                
                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 415,
                    
                ],
            ];

        },
        500 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Internal Server Error',
                'details' => $a,
                
                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 500,
                    
                ],
            ];

        },
        501 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Not Implemented',
                'details' => $a,

                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 501,
                    
                ],
            ];

        },
        503 => function($a = []) {
            return [
                'status' => false,
                'message' => 'Service Unavailable',
                'details' => $a,

                /**
                 * This is wont be printed.
                 */
                '_triangle' => [
                    'code' => 503,
                    
                ],
            ];

        },
    ]
]));