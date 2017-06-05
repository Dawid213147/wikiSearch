<?php
namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller 
 * @author Dawid
 */
class SearchController extends Controller {

    /**
     * * @Route("/search", name="app")
     * @return string
     *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request) {
        $wikiPages = $this->get('wiki_search.service');

        $searchValue = $request->query->get('form')['wikiSearch'];
        $searchLimit = $request->query->get('limit') ? $request->query->get('limit') : 10;
        $webServis = $this->container->getParameter('http_web_service');
        $searchResult = $wikiPages->getHttpRequestResult($searchValue, $webServis, $searchLimit);
        
        $requestUri = strtok($request->getRequestUri(),'&');
        $urlDecode = urldecode($requestUri);


        $client = $this->get('wiki_factory.client')->createClient();
        $client->setSearch($searchValue);
        $client->setResultCount($searchLimit);

        $clientHandler = $this->get('wiki_client.client_handler');
        $clientHandler->saveClient($client);

        $response = $this->render(
            'WikiSearchBundle:Search:search.html.twig', [
            'wikiPages' => $searchResult,
            'searchValue' => $searchValue,
            'decodeUrl' => $urlDecode,
        ]);
   
        return $response;
    }

    /**
     * @Route("/my", name="my")
     */
    public function myAction()
    {
        $clientProvider = $this->get('wiki_client.provider.service');
        $clients = $clientProvider->getClients();
        var_dump($clients);exit;
    }
}
