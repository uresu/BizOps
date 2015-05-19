<?php

namespace Node4\DataMiningBundle;

use Node4\DataMiningBundle;

class LinkedIn
{
    public $term;

    public function getCompanyURI($company)
    {
        $this->term = $company;
        $finder = new GoogleFirstResultScraper();
        $url = $finder->returnResult($this->term);
        return $url;
    }
}