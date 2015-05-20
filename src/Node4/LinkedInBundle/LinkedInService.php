<?php

namespace Node4\LinkedInBundle;

use Happyr\LinkedIn\Exceptions\LinkedInApiException;
use Happyr\LinkedIn\LinkedIn;

/**
 * Extends the LinkedIn class
 */
class LinkedInService extends LinkedIn
{
    /**
     * @var string scope
     */
    protected $scope;

    /**
     * @param string $appId
     * @param string $secret
     * @param string $scope
     */
    public function __construct($appId, $secret, $scope)
    {
        $this->scope = $scope;
        parent::__construct($appId, $secret);
    }

    /**
     * Set the scope
     *
     * @param array $params
     *
     * @return string
     */
    public function getLoginUrl($params = array())
    {
        if (!isset($params['scope']) || $params['scope'] == "")
        {
            $params['scope'] = $this->scope;
        }

        return parent::getLoginUrl($params);
    }

    /**
     * I override this function because I want the default user array to include email-address
     */
    protected function getUserFromAccessToken()
    {
        try
        {
            return $this->api('GET', '/v1/people/~:(id,firstName,lastName,headline,email-address)');
        }
        catch (LinkedInApiException $e)
        {
            return null;
        }
    }
}