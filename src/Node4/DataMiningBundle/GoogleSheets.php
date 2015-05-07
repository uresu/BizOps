<?php

namespace Node4\DataMiningBundle;

use Node4\DataMiningBundle;
use Google_Client;

class GoogleSheets
{
    private $clientId      = '707198933174-dgpbqeo1cj2552lvh6e32od5crjqudjt.apps.googleusercontent.com';
    private $clientSecret  = 'b3RyOUHCiR-Y4xeZA9qWkmy1';
    private $redirectUrl   = 'https://localhost/oauth2callback';
    private $clientAppName = 'Node4DataMiner';

    public function listSheets($url)
    {
        $serviceRequest = new DefaultServiceRequest($accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);

        $spreadsheetService = new SpreadsheetService();
        $spreadsheetFeed = $spreadsheetService->getSpreadsheets();
    }

    public function getToken()
    {
        $client = new \Google_Client();

        $client->setClientId($this->clientId);
        $client->setApplicationName($this->clientAppName);
        $client->setDeveloperKey($this->clientSecret);
        $client->setRedirectUri($this->redirectUrl);

        $service = new \Google_Service_Books($client);
        $optParams = array('filter' => 'free-ebooks');
        $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

        return $client->getAccessToken();
    }
}