<?php

namespace Omnipay\WePay;

trait UsesEnvironmentVariablesTrait
{
    protected function getAccessToken()
    {
        return getenv('ACCESS_TOKEN');
    }

    protected function getClientSecret()
    {
        return getenv('CLIENT_SECRET');
    }

    protected function getClientId()
    {
        return getenv('CLIENT_ID');
    }

    protected function getTestmode()
    {
        $mode = getenv('TEST_MODE');
        return $mode === false || strtolower(getEnv('TEST_MODE')) !== 'false';
    }

    protected function getEnv($key)
    {
        $value = getenv($key);
        return $value === false ? null : $value;
    }
}
