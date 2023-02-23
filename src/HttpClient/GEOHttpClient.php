<?php

namespace App\HttpClient;

use App\Factory\XmlResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 *  Class GEOttpClient
 *   @package App\Client 
 */

class GEOHttpClient extends AbstractController{


    /**
     * @varHttpClientInterface
     */
    private $httpClient;

    /**
     * GEOHttpClient constructor
     * 
     * @param HttpClientInterface $geo
     */
    public function __construct(HttpClientInterface $geo)
    {
        $this->httpClient = $geo;
    }

    public function getVilles($search){
        // On passe par le client http pour faire une requête = mettre l'url voulue
        $response = $this->httpClient->request('GET', "/communes?nom=$search&fields=departement&limit=5", [
            // verify_peer false permet de passer outre les certificats SSL qui peuvent ne pas faire fonctionner l'appel à l'API (selon ce que les créateurs de l'api ont définit comme sécurité)
            'verify_peer' => false,
        ]);
        return $response->getContent();
    }
}

?>