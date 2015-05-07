<?php

namespace Node4\DataMiningBundle;

use Goutte\Client;
use Node4\DataMiningBundle;

class GoogleFirstResultScraper
{
    public $term;

    public function returnResult($term)
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