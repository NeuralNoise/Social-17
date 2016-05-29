<?php

namespace PHPixie\Social;

class Builder
{
    protected $configData;

    protected $http;
    protected $format;
    protected $providers;

    protected $providerClassMap = array(
        'facebook'=> '\PHPixie\Social\Providers\Facebook\Provider',
        'google'  => '\PHPixie\Social\Providers\Google\Provider',
        'twitter' => '\PHPixie\Social\Providers\Twitter\Provider',
        'vk'      => '\PHPixie\Social\Providers\VK\Provider',
    );

    public function __construct($configData)
    {
        $this->configData = $configData;
    }

    public function providers()
    {
        if($this->providers === null) {
            $this->providers = new Providers($this, $this->configData);
        }

        return $this->providers;
    }

    public function http()
    {
        if($this->http === null) {
            $this->http = new HTTP();
        }

        return $this->http;
    }

    public function format()
    {
        if($this->format === null) {
            $this->format = new Format();
        }

        return $this->format;
    }

    public function oauthAccessToken($providerName, $userId, $accessToken, $expiresAt)
    {
        return new \PHPixie\Social\OAuth\Token\AccessToken(
            $name,
            $userId,
            $accessToken,
            $expiresAt
        );
    }

    public function oauthUser($provider, $token, $loginData = null)
    {
        return new \PHPixie\Social\OAuth\User($provider, $token, $loginData);
    }

    public function buildProvider($type, $name, $configData)
    {
        if(!isset($this->providerClassMap[$type])) {
            throw new \PHPixie\Social\Exception("Provider type '$type' does not exist.");
        }

        $class = $this->providerClassMap[$type];
        return new $class($this, $name, $configData);
    }
}
