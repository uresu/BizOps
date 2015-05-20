<?php

namespace Node4\DataMiningBundle;

use Node4\DataMiningBundle;
use Goutte\Client;

class Google
{
    private $clientId           = '707198933174-dgpbqeo1cj2552lvh6e32od5crjqudjt.apps.googleusercontent.com';
    private $clientAppName      = 'Node4DataMiner';
    private $serviceAccountName = '707198933174-jjlnqlmhsns87bs4ej7117ign5kbdufg@developer.gserviceaccount.com';
    private $scopes             = array();
    private $client;
    private $p12Key;
    private $keyFileLocation;
    public  $term;

    public function __construct()
    {
        define ('KEY_FILE_LOCATION', '/Node4DataMiner-bb2c8300aec2.p12');
        $this->extractKeyFromP12File();
    }

    public function extractKeyFromP12File()
    {
        $this->p12Key = file_get_contents(__DIR__ . KEY_FILE_LOCATION);
    }

    public function setupClient()
    {
        $this->client = new \Google_Client();
        $this->client->setClientId($this->clientId);
        $this->client->setApplicationName($this->clientAppName);
        $this->scopes[] = 'https://www.googleapis.com/auth/drive';
        $this->scopes[] = 'https://spreadsheets.google.com/feeds';
    }

    public function getOauthToken()
    {
        $this->setupClient();
        $creds = new \Google_Auth_AssertionCredentials($this->serviceAccountName, $this->scopes, $this->p12Key);
        $this->client->setAssertionCredentials($creds);

        if ($this->client->getAuth()->isAccessTokenExpired())
        {
            $this->client->getAuth()->refreshTokenWithAssertion($creds);
        }

        $token = $this->client->getAccessToken();
        $decoded = json_decode($token, true);
        $tokenString = $decoded['access_token'];
        return $tokenString;
    }

    public function listFiles($token)
    {
        $lister = new \Google_Service_Drive($this->client);
        $files = $lister->files->listFiles();
    }

    public function readSheetData()
    {

    }

    public function returnDriveObject($client)
    {
        return new \Google_Service_Drive($client);
    }

    public function getSheetKeyByTitle($title)
    {

    }

    public function returnFirstResult($term)
    {
        $this->term = $term;
        $client = new Client();
        $client->setHeader('User-Agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
        $crawler = $client->request('GET', 'https://www.google.co.uk');

        $form = $crawler->selectButton('Google Search')->form();
        $form['q'] = $this->term . 'linkedin ';

        // submit that form
        $crawler = $client->submit($form);

        $url =
            (
                $crawler
                ->filter('#rso > div.srg > li:nth-child(1) div > h3 > a')
                ->extract('href')
            );

        return $url[0];
    }

}