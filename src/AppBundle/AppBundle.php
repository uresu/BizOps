<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    function Run()
    {
        $company = 'Box UK';
        $obj     = new Node4\LinkedIn();
        $URI     = $obj->getCompanyURI($company);

        return $URI;
    }
}