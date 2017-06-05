<?php
namespace Wiki\SearchBundle\Repository\Client;

use Wiki\SearchBundle\Entity\Client;

interface ClientRepositoryInterface
{
    public function save(Client $client);
}
