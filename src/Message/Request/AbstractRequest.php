<?php
/**
 * Contains base class for requests
 */
namespace Omnipay\WePay\Message\Request;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use WePay;
use WePayException;
use WePayRequestException;
use Omnipay\WePay\Message\Response\Generic;
use Omnipay\WePay\Requests\Router;
use Omnipay\WePay\RouterHooksTestModeTrait;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\RuntimeException;
use Omnipay\Common\Helper;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use RouterHooksTestModeTrait;

    /**
     * gets the endpoint for the request
     * @return string
     */
    abstract public function getEndpoint();

    /**
     * @return retrieves data for api requests
     */
    abstract public function getData();

    public function getHttpMethod()
    {
        if (property_exists($this, 'http_method')) {
            return $this->http_method;
        }

        return 'POST';
    }

    public function buildEndpoint()
    {
        return Router::getEndpoint($this->getEndpoint());
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data = null)
    {
        $headers = $this->getApiHeaders();
        $httpMethod = strtoupper($this->getHttpMethod());
        switch ($httpMethod) {
            case 'POST':
                $data = json_encode(is_null($data) ? [] : $data);
                break;
            case 'GET':
                $data = $data ? http_build_query($data, '', '&') : null;
                break;
        }

        $httpResponse = $this->httpClient->request(
            $httpMethod,
            $this->buildEndpoint(),
            $headers,
            $data
        );

        return $this->createResponse(
            $httpResponse->getBody()->getContents(),
            $httpResponse->getHeaders(),
            $httpResponse->getStatusCode(),
            $httpResponse->getReasonPhrase()
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

    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new Generic($this, $data, $headers, $code, $status_reason);
    }
}
