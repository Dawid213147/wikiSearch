<?php

namespace Wiki\SearchBundle\Tests\Helper;

use Wiki\SearchBundle\Service\HttpRequest\HttpRequestSearch;

/**
 * Class implements Unit test for send request to wiki api
 *
 * @author Dawid
 */
class HttpRequestSearchTest extends \PHPUnit_Framework_TestCase {

    /**
     * Check request to wiki api
     */
    public function testGetHttpRequestResult() {

        $request = new HttpRequestSearch();

        $result = $request->getHttpRequestResult('Canada', 'http://en.wikipedia.org/w/api.php', 1);
        $expected = array(
            0 => array(
                "ns" => "0",
                "title" => "Canada",
                "size" => "186007",
                "wordcount" => "16885",
                "snippet" => "For other uses, see <span class=\"searchmatch\">Canada</span> (disambiguation). Coordinates: 60°N 95°W﻿ / ﻿60°N 95°W﻿ / 60; -95 <span class=\"searchmatch\">Canada</span> (i/ˈkænədə/; French: [ka.na.dɑ]) is a country in the",
                "timestamp" => "2017-05-03T22:37:57Z",
                "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Flag_of_Canada_%28Pantone%29.svg/100px-Flag_of_Canada_%28Pantone%29.svg.png"
            )
        );

        $this->assertEquals($expected, $result);
    }

}
