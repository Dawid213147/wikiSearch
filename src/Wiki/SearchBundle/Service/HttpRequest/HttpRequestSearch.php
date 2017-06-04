<?php

namespace Wiki\SearchBundle\Service\HttpRequest;

use Wiki\SearchBundle\Service\HttpRequestService;
use Wiki\SearchBundle\Service\HttpRequest\HttpRequestImage;

/**
 * Class creata a request to webservice
 * @author Dawid
 */
class HttpRequestSearch extends HttpRequestService {

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

        parent::__construct();
        $this->image = new HttpRequestImage();
    }

    /**
     * Return result of request to web serwise
     * @param string $search
     * @return array
     */
    public function getHttpRequestResult($search, $webService, $limit) {

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

        $wikiPages = json_decode(json_encode($pages->query->search), TRUE);
        if ($wikiPages != NULL) {
            $cleanArray = call_user_func_array('array_merge', $wikiPages);

            $singleResult = [];

            foreach ($cleanArray as $key => $row) {
                $singleResult[] = call_user_func_array('array_merge', $row);
                if ($key == 'p') {
                    $key = 0;
                }

                $singleResult[$key]['image'] = $image->getHttpRequestImage($singleResult[$key]['title'], $webService);
            }

            return $singleResult;
        }
        return NULL;
    }

}
