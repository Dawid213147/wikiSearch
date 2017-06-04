<?php

namespace Wiki\SearchBundle\Service\HttpRequest;

use Wiki\SearchBundle\Service\HttpRequestService;

/**
 * Class create request to get a image url form wiki api
 *
 * @author Dawid
 */
class HttpRequestImage extends HttpRequestService{

    /**
     * Return result of request to web serwise
     * @param string $search
     * @param string $webService
     * @return boolean|string
     */
    public function getHttpRequestImage($search, $webService) {

        $client = $this->client;

        try {
            $request = $client->request('GET', $webService, [
                'verify' => false,
                'query' => [
                    'action' => 'query',
                    'prop' => 'pageimages',
                    'titles' => $search,
                    'pithumbsize' => 100,
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
     * Return array result of search image
     * @return string|NULL
     */
    private function prepareData() {

        $pagesImage = $this->getRequestBodyAsObject();
        $wikiImage = json_decode(json_encode($pagesImage->query->pages->page->thumbnail['source']), TRUE);

        if ($wikiImage != NULL) {

            return $wikiImage[0];
        }

        return NULL;
    }
}
