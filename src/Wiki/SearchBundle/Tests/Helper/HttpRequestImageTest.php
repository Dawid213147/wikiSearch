<?php

namespace Wiki\SearchBundle\Tests\Helper;

use Wiki\SearchBundle\Helper\HttpRequestImage\HttpRequestImage;

/**
 * Class implements Unit test for get image url form wiki api
 *
 * @author Dawid
 */
class HttpRequestImageTest extends \PHPUnit_Framework_TestCase {

    /**
     * Check image url from wiki api
     */
    public function testGetHttpRequestResult() {

        $request = new HttpRequestImage();

        $result = $request->getHttpRequestImage('Canada', 'http://en.wikipedia.org/w/api.php');
        $expected = "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Flag_of_Canada_%28Pantone%29.svg/100px-Flag_of_Canada_%28Pantone%29.svg.png";
          
        $this->assertEquals($expected, $result);
    }

}
