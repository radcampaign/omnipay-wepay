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
use Omnipay\WePay\WePayDefaultGettersAndSettersTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use RouterHooksTestModeTrait,
        WePayDefaultGettersAndSettersTrait;

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

    /**
     * Creates the new endpoint in full
     *
     * @return string
     */
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
     * Get api header
     *
     * @return array
     */
    public function getApiHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new Generic($this, $data, $headers, $code, $status_reason);
    }

    /**
     * Checks if the instance has a parameter set
     *
     * @param  string  $key the parameter key to check
     * @return boolean
     */
    public function hasParameter($key = '')
    {
        if ($this->parameters instanceof ParameterBag) {
            return $this->parameters->has($key);
        }

        return false;
    }

    /**
     * For cli testing and var_dumping. Helps see what is going on
     * with our Request
     *
     * @return array
     */
    public function __debugInfo()
    {
        $endpoint = $this->buildEndpoint();
        try {
            $request_data = $this->getData();
        }
        catch (InvalidRequestException $error) {
            $request_data = [];
            $error = [
                'error_code' => $error->getCode(),
                'error_message' => $error->getMessage(),
            ];
        }

        $dump = compact('endpoint', 'request_data');
        if (isset($error)) {
            $dump['error'] = $error;
        }
        return $dump;
    }
}
