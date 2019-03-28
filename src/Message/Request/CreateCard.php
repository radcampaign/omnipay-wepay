<?php
/**
 * Makes Requests
 */
namespace Omnipay\WePay\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Message\Response\CreateCardResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;

class CreateCard extends AbstractRequest
{
    /**
     * Uses overloading for lazy loading parameters so that
     * we don't have to write setters and getters for each one
     * - must set the class property `$accepted_parameters`
     * DELETE THIS IF YOU DON'T WANT TO USE IT
     */
    // use LazyLoadParametersTrait;


    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        // use this to define the data that is sent with requests
        $card = $this->getCard();

        return [
            'client_id' => $this->getClientid(),
            'cc_number' => $this
        ];
    }

    /**
     * Sets the api endpoint for the request. i.e 'account/find'
     *
     * @see AbstractRequest::buildEndpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        // set the endpoint
        return 'credit_card/create';
    }

    public function setCard($value)
    {
        return $this->setParameter('card', $value);
    }

    public function getCard()
    {
        return $this->getParameter('card');
    }

    public function setClientId($value)
    {
        return $this->setParameter('client_id', $value);
    }

    public function getClientId()
    {
        return $this->getParameter('client_id');
    }

    /**
     * Creates our response
     *
     * @param  array   $data           Data from the response
     * @param  array   $headers        Headers from the response
     * @param  integer $code           The status code
     * @param  string  $status_reason  The status reason
     * @return CreateCardResponse
     */
    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new CreateCardResponse($this, $data, $headers, $code, $status_reason);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(...$args)
    {
        $args = array_merge($args, ['client_id', 'card']);
        call_user_func_array('parent::validate', $args);

        // now lets validate our card
        $card = $this->getCard();
        $card->validate();
        // wepay also requires that the card has
        // user_name (full name), email and address
        $first_name = $card->getFirstName();
        $last_name = $card->getLastName();

    }
}
