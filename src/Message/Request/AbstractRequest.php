<?php
/**
 * Contains base class for requests
 */
namespace Omnipay\WePay\Message\Request;

use Omnipay\Common\Message\AbstractRequest as BaseAbstract;
use WePay;
use WePayException;
use WePayRequestException;
use Omnipay\WePay\Message\Response\GenericResponse;

abstract class AbstractRequest extends BaseAbstract
{
    /**
     * The live api url
     * @var string
     */
    protected $live_api_url = 'https://wepayapi.com/v2/';

    /**
     * The staging api url
     * @var string
     */
    protected $staging_api_url = 'https://stage.wepayapi.com/v2/';

    /**
     * Retrieves the api url - test mode uses the staging url
     * and live uses the live url
     * @return string
     */
    public function getApiUrl()
    {
        return $this->getTestMode() ? $this->staging_api_url : $this->live_api_url;
    }

    /**
     * gets the endpoint for the request
     * @return string
     */
    abstract public function getEndpoint();

    /**
     * @return retrieves data for api requests
     */
    abstract public function getData();

    /**
     * We want the endpoint to be just a path.
     * i.e. - "/user" or "user".
     * We wll add the full path to the url.
     * @return string
     */
    public function buildEndpoint()
    {
        $endpoint = $this->getEndpoint();
        // remove webpoints that begin with
        if (substr($endpoint, 0, 1) === '/') {
            $endpoint = substr($endpoint,1);
        }

        return $this->getApiUrl() . $endpoint;
    }

    public function getHttpMethod()
    {
        if (property_exists($this, 'http_method')) {
            return $this->http_method;
        }

        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $headers = $this->getApiHeaders();
        $body = $data ? http_build_query($data, '', '&') : null;

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->buildEndpoint(),
            $headers,
            $body
        );

        return $this->createResponse(
            $httpResponse->getBody()->getContents(),
            $httpResponse->getHeaders()
        );
    }

    /**
     * retrieves the access token to make requests on
     * @return string
     */
    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }

    /**
     * Sets the access token
     * @param string $value  the access token to make requests on
     */
    public function setAccessToken($value = '')
    {
        return $this->setParameter('accessToken', $value);
    }

    /**
     * Get api header
     * @return array
     */
    public function getApiHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ];
    }

    protected function createResponse($data, $headers = [])
    {
        return $this->response = new GenericResponse($this, $data, $headers);
    }
}
