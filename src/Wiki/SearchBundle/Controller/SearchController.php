<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Wiki\SearchBundle\Helper\HttpRequest\HttpRequest;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller {

    /**
     * @Route("/search")
     * @return string
     */
    public function searchAction(Request $request) {
        $wikiPages = new HttpRequest();
        $searchValue = $request->request->get('form')['wikiSearch'];
        $web_serwise = $this->container->getParameter('http_web_service');
        $searchResult = $wikiPages->getHttpRequestResult($searchValue, $web_serwise);
        $response = $this->render(
            'WikiSearchBundle:Search:search.html.twig', [
            'wikiPages' => $searchResult,
        ]);
        
        return $response;
    }

}
