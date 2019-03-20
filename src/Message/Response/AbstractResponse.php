<?php

namespace Omnipay\WePay\Message\Response;

use Omnipay\Common\Message\AbstractResponse as BaseAbstract;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends BaseAbstract
{

    protected $requestId = null;

    protected $headers = [];

    protected $status_code;

    protected $status_reason;

    public function __construct(RequestInterface $request, $data, $headers = [], $code, $status_reason = '')
    {
        $this->status_code = $code;
        $this->status_reason = $status_reason;
        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
    }

    /**
     * Gets the data
     *
     * @param  string $key optional to retrieve a specific key
     * @return mixed
     */
    public function getData($key = null)
    {
        if (is_null($key)) {
            return parent::getData();
        }

        return $this->data[$key] ?? null;
    }

    /**
     * Gets the status code
     *
     * @return string
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * Gets the status reason
     *
     * @return string
     */
    public function getStatusReason()
    {
        return $this->status_reason;
    }

    /**
     * Checks if the response was successful
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return !$this->isError();
    }

    /**
     * Gets the response headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /*
     API errors follow a similar patter so we can
     abstract some getter functions

     @see https://developer.wepay.com/api/general/errors
     */

    /**
     * Checks if the response is an error
     *
     * @return boolean
     */
    public function isError()
    {
        return !is_null($this->getError());
    }

    /**
     * Gets the error
     *
     * @return null|string
     */
    public function getError()
    {
        return $this->getData('error');
    }

    /**
     * Gets the error description
     *
     * @return string|null
     */
    public function getErrorDescription()
    {
        return $this->getData('error_description');
    }

    /**
     * Gets the error code
     *
     * @return integer|null
     */
    public function getErrorCode()
    {
        return $this->getData('error_code');
    }

    /**
     * Gets the error details
     *
     * @return array|null
     */
    public function getErrorDetails()
    {
        return $this->getData('details');
    }
}
