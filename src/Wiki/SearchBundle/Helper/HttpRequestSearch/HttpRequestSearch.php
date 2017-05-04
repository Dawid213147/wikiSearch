<?php

namespace Wiki\SearchBundle\Helper\HttpRequestSearch;

use GuzzleHttp\Client;
use Wiki\SearchBundle\Helper\HttpRequestImage\HttpRequestImage;

/**
 * Class creata a request to webservice
 * @author Dawid
 */
class HttpRequestSearch {

    /**
     * Value of a http client
     * @var object
     */
    private $client;

    /**
     * Value of a request
     * @var string 
     */
    private $request;

    /**
     * Value with request to get image
     * @var object 
     */
    private $image;
    
    /**
     * Value of web service 
     * @var string 
     */
    private $webService;
    
    /**
     * Constructor
     */
    public function __construct() {

        $this->client = new Client();
        $this->image = new HttpRequestImage();
    }

    /**
     * Return result of request to web serwise
     * @param string $search
     * @return array
     */
    public function getHttpRequestResult($search, $webService, $limit) {

        set_time_limit(360);
        $this->webService = $webService;
        $client = $this->client;
        try {
            $request = $client->request('GET', $webService, [
                'verify' => false,
                'query' => [
                    'action' => 'query',
                    'list' => 'search',
                    'srwhat' => 'text',
                    'srsearch' => $search,
                    'srlimit' => $limit,
                    'format' => 'xml'
                ]
            ]);
            $this->request = $request;
            $result = $this->prepareData();
            return $result;
        } catch (\Exception $e) {
            return FALSE;
        }
    }

    /**
     * Return array result of search
     * @return array|NULL
     */
    private function prepareData() {

        $pages = $this->getRequestBodyAsObject();
        $webService = $this->webService;
        $image = $this->image;

        if ($pages != NULL) {

            $wikiPages = json_decode(json_encode($pages->query->search), TRUE);

                $cleanArray = call_user_func_array('array_merge', $wikiPages);

                $singleResult = [];

                foreach ($cleanArray as $key => $row) {
                    $singleResult[] = call_user_func_array('array_merge', $row);
                    if ($key == 'p') $key = 0;
                    $singleResult[$key]['image'] = $image->getHttpRequestImage($singleResult[$key]['title'], $webService);
                                        
                }
              
                return $singleResult;
        }
        return NULL;
    }

    /**
     * Get xml with search results
     * @return object \SimpleXMLElement
     */
    private function getRequestBodyAsObject() {

        $request = $this->request;

        $body = $request->getBody();
        $xmlObject = new \SimpleXMLElement($body);

        return $xmlObject;
    }

    public function clean($string) {
        
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
    
    }
    
}
