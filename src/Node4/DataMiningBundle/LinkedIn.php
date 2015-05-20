<?php

namespace Node4\DataMiningBundle;

use Node4\DataMiningBundle;
use Goutte\Client;

class LinkedIn
{
    public $term;

    public function getCompanyURI($company)
    {
        $this->term = $company;
        $finder = new Google();
        $url = $finder->returnFirstResult($this->term);

        if(strpos($url, 'linkedin.com') === false)
        {
            return FALSE;
        }
        else
        {
            return $url;
        }
    }

    public function getCompanyIdFromName($company)
    {
        $client = new Client();
        $client->setHeader('User-Agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
        $crawler = $client->request('GET', $this->getCompanyURI($company));


        $tag   = $crawler->filterXPath('//*[@id="biz-connectedness-top"]/div/div/ul[1]')->nodeName();
        $class = $crawler->filterXPath('//*[@id="biz-connectedness-top"]/div/div/ul[1]')->attr('class');

        var_dump($tag);

    }
}
