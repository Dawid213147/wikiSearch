<?php
namespace Wiki\SearchBundle\Service\Client;

use Wiki\SearchBundle\Entity\Client;
use Wiki\SearchBundle\Repository\Client\ClientRepositoryInterface;

class ClientHandler
{

    private $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function saveClient(Client $client)
    {
        $this->clientRepository->save($client);
    }
}
