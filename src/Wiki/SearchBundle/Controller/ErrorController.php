<?php

namespace Wiki\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of ErrorController
 *
 * @author Dawid
 */
class ErrorController extends Controller  {
    
    /**
     * @Route("/error", name="error_redirect")
     * @return string
     */
    public function errorAction() {
        
        $response = $this->render(
            'WikiSearchBundle:Error:error.html.twig');
   
        return $response;
    }
    
     /**
     * @Route("/nullError", name="nullError_redirect")
     * @return string
     */
    public function nullErrorAction() {
        
        $response = $this->render(
            'WikiSearchBundle:Error:nullError.html.twig');
   
        return $response;
    }
}
