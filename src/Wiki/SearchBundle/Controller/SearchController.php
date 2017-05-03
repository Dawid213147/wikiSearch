<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Wiki\SearchBundle\Helper\HttpRequest\HttpRequest;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller {

    /**
     * @Route("/search", name="ajax_search")
     * @return string
     */
    public function searchAction(Request $request) {
        $wikiPages = new HttpRequest();
        $searchValue = $request->query->get('form')['wikiSearch'];
        $searchLimit = $request->query->get('limit') ? $request->query->get('limit') : 10;
        $web_serwise = $this->container->getParameter('http_web_service');
        $searchResult = $wikiPages->getHttpRequestResult($searchValue, $web_serwise, $searchLimit);
        $url = strtok($request->getRequestUri(),'&');
        $urlDecode = urldecode($url);
        $response = $this->render(
            'WikiSearchBundle:Search:search.html.twig', [
            'wikiPages' => $searchResult,
            'searchValue' => $searchValue,
            'decodeUrl' => $urlDecode,
        ]);
   
        return $response;
    }

}
