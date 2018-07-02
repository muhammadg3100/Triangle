# Triangle
Triangle is a web application for your rest api solution, we make the code and the system as beautiful as posible, its provide much feature, such as:
1. Auto format your respond or response, like XML and JSON.
2. Simple, and fast route for every api.
3. Easy to code.

It's make your work more easier, because it's easy to integrate with your Desktop Applications. such as C, C#, C++, .NET, or other.

## Usage
Method name must be lower case, when the array returned from the method its will automatically converted to the client expected.
```php
class demo {
    public function __construct() {
        // You can add your script here, like authentication or etc.
        
        // To push directly
        global $_triangle;
        $_triangle->push([
            'status' => false,
            'message' => 'Hey There!',
            
        ]);
        
    }
    // alawys use private function for private thing.
    private function getToken() {

    }
    public function get() {
        // Must be returned as array
        return [
            'status' => true,
            'message' => 'Hello World! This is GET HTTP Method.',
            
            /**
             * it's optional.
             */
            '_triangle' => [
                /**
                 * it's optional either.
                 * but default is 200
                 *
                 */
                'code' => 200,
                
                /**
                 * it's optional either.
                 */
                'header' => [
                    'X-Version' => 1.0
                ],
            ],
        ];

    }
    public function post() {
        return [
            'status' => true,
            'message' => 'HTTP POST Method!',

        ];

    }
    public function AnyHTTPMethodName() {
        return [
            'status' => true,
            'message' => 'HTTP DELETE Method!',

        ];

    }
}
```
The file name must be <b>(class name)</b>.class.php, and the URL Path will looks like: 
1. http://api.example.com/<b>(class name)</b>
2. http://api.example.com/<b>(folder name)</b>/<b>(class name)</b>

and so on.

## FAQ
When the response is JSON / XML, the $_POST data will be replaced to json or xml converted to array.


## Contributors
1. Nikko Enggaliano - thanks for the project name though.

## License
The triangle framework is open-sourced software licensed under the MIT license.
