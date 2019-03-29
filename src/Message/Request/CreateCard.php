<?php
/**
 * Makes Requests to create a credit card
 * @see https://developer.wepay.com/api/api-calls/credit_card#create
 */
namespace Omnipay\WePay\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Message\Response\CreateCardResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\CreditCard;
use Omnipay\WePay\Helper;
use Omnipay\WePay\Services\Services;

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
     * Maps the keys as the wepay request accepts them
     * to the CreditCard object methods. the value is the part
     * of the method minus the prefix get or set
     *
     * @var array
     */
    protected $card_map = [
        'cc_number'        => 'Number',
        'expiration_month' => 'ExpiryMonth',
        'expiration_year'  => 'ExpiryYear',
        'user_name'        => 'BillingName',
        'email'            => 'Email',
        'cvv'              => 'Cvv',
    ];

    /**
     * Retrieves the default data for the request
     *
     * @return array
     */
    public function getDefaultData()
    {
        return [
            'client_id'            => $this->getClientid(),
            'cc_number'            => null,
            'expiration_month'     => null,
            'expiration_year'      => null,
            'user_name'            => null,
            'email'                => null,
            'address'              => null,
            'cvv'                  => null,
            'original_ip'          => $this->getClientIp(),
            'original_device'      => $this->getClientDevice(),
            'reference_id'         => $this->getClientDevice(),
            'auto_update'          => $this->getAutoUpdate(),
            'callback_uri'         => $this->getCallbackUri(),
            'virtual_terminal'     => $this->getVirtualTerminal(),
            'payment_request_flag' => $this->getPaymentRequestFlag(),
            'card_on_file'         => $this->getCardOnFile(),
            'recurring'            => $this->getRecurring(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        // use this to define the data that is sent with requests
        $ret = $this->getDefaultData();

        $card = $this->getCard();

        $data = [];

        if (!is_null($card)) {
            foreach ($this->card_map as $key => $value) {
                $getter = 'get' . $value;
                $data[$key] = $card->$getter();
            }

            // this will transform data from our
            // credit card into the WePay Address Structure
            $service = Services::get('rs_cc')
                        ->setRSTag('address')
                        ->setCreditCard($card);
            $address = $service->invoke();

            if (!$address->isEmpty()) {
                $data['address'] = $address;
            }
        }

        return Helper::arrayStripNulls(
            Helper::arrayStrictReplace(
                $ret,
                $data
            )
        );
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

    public function setClientId($value)
    {
        return $this->setParameter('client_id', $value);
    }

    public function getClientId()
    {
        return $this->getParameter('client_id');
    }

    /**
     * Gets the client device. Client device is different than ClientID.
     * Client ID refers to us, our application id, but client device
     * refers to the user who puts there info in.
     *
     * @return string
     */
    public function getClientDevice()
    {
        return $this->getParameter('client_device');
    }

    /**
     * Sets the client device. Client device is different than ClientID.
     * Client ID refers to us, our application id, but client device
     * refers to the user who puts there info in.
     *
     * @param string $value
     * @return $this
     */
    public function setClientDevice($value)
    {
        return $this->setParameter('client_device', $value);
    }

    public function getCallbackUri()
    {
        return $this->getParameter('callback_uri');
    }

    public function setCallbackUri($value)
    {
        return $this->setParameter('callback_uri', $value);
    }

    public function getVirtualTerminal()
    {
        return $this->getParameter('virtual_terminal');
    }

    public function setVirtualTerminal($value)
    {
        return $this->setParameter('virtual_terminal', $value);
    }

    public function getPaymentRequestFlag()
    {
        return $this->getParameter('payment_request_flag');
    }

    public function setPaymentRequestFlag($value)
    {
        return $this->setParameter('payment_request_flag', $value);
    }

    public function getCardOnFile()
    {
        return $this->getParameter('card_on_file');
    }

    public function setCardOnFile($value)
    {
        return $this->setParameter('card_on_file', $value);
    }

    public function getRecurring()
    {
        return $this->getParameter('recurring');
    }

    public function setRecurring($value)
    {
        return $this->setParameter('recurring', $value);
    }

    public function getAutoUpdate()
    {
        return $this->getParameter('auto_update');
    }

    public function setAutoUpdate($value)
    {
        return $this->setParameter('auto_update', $value);
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
    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
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
        if (empty($card->getName())) {
            throw new InvalidRequestException('The credit card must have a name set');
        }
    }
}
