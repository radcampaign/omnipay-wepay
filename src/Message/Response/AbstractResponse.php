<?php

namespace Omnipay\WePay\Message\Response;

use Omnipay\Common\Message\AbstractResponse as BaseAbstract;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends BaseAbstract
{

    protected $requestId = null;

    protected $headers = [];

    public function __construct(RequestInterface $request, $data, $headers = [])
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
    }

    public function getData($key = null)
    {
        if (is_null($key)) {
            return parent::getData();
        }

        return $this->data[$key] ?? null;
    }

    public function isSuccessful()
    {
        return true;
    }
}
