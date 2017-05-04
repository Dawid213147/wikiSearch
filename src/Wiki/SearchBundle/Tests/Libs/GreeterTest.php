<?php

namespace Wiki\SearchBundle\Tests\Libs;

use Wiki\SearchBundle\Libs\Greeter;


/**
 * Description of GreeterTest
 *
 * @author Dawid
 */
class GreeterTest extends \PHPUnit_Framework_TestCase {
    public function testDisplay() {
        $greeting = new Greeter();
        $result = $greeting->display('John');
        
        $expected = 'John, you are te coolest person..';
     
        $this->assertEquals($expected, $result);
    }
}
