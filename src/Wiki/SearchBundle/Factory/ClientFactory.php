<?php
namespace Wiki\SearchBundle\Factory;

use Wiki\SearchBundle\Entity\Client;

class ClientFactory
{

    public function createClient()
    {
        return new Client();
    }
}