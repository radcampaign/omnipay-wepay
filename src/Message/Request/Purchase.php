<?php
/**
 * Makes Requests
 */
namespace Omnipay\WePay\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Message\Response\PurchaseResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\WePay\Helper;

class Purchase extends AbstractRequest
{
    use PaymentRequestTrait;

    /**
     * Uses overloading for lazy loading parameters so that
     * we don't have to write setters and getters for each one
     * - must set the class property `$accepted_parameters`
     * DELETE THIS IF YOU DON'T WANT TO USE IT
     */
    use LazyLoadParametersTrait;

    /**
     * Retrieves the paramaters that are accepted by our request
     *
     * @see LazyLoadParametersTrait::getAcceptedParameters()
     * @return array   an associative array
     */
    protected function getDefaultAcceptedParameters()
    {
        return [
            'account_id' => true,
            'description' => true,
            'type' => true,
            'amount' => true,
            'currency' => true,
            'long_description' => false,
            'email_message' => false,
            'fee' => false,
            // 'reference_id' => false, - comes from TransactionId
            // 'unique_id' => false, - also comes from the TransactionID
            'payer_rbits' => false,
            'transaction_rbits' => false,
        ];
    }

    /**
     * Gets the parameters that are required
     *
     * @return array
     */
    protected function getRequiredParameters()
    {
        $params = $this->getDefaultAcceptedParameters();
        $ret = [];
        foreach ($params as $param => $required) {
            if ($required === true) {
                array_push($ret, $param);
            }
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        // use this to define the data
        $short_description = $this->getDescription();
        $long_description = $this->getSlongDescription();
        if (empty($long_description)) {
            $long_description = $short_description;
        }

        $transaction_id = (string) $this->getTransactionId();

        $fee = $this->getFeeStructure();
        $data = [
            'account_id'        => $this->getAccountId(),
            'reference_id'      => $transaction_id,
            'amount'            => $this->getAmount(),
            'type'              => $this->getType(),
            'currency'          => $this->getCurrency(),
            'short_description' => $this->getDescription(),
            'long_description'  => $long_description,
            'fee'               => $fee->isEmpty() ? null : $fee,
            'callback_uri'      => $this->getCallbackUri(),
            'initiated_by'      => $this->getInitiatedBy(),
            'auto_release'      => $this->getAutoRelease(),
            'delivery_type'     => $this->getDeliveryType()
        ];

        if ($this->isHostedCheckout()) {
            $data['hosted_checkout'] = $this->getHostedCheckoutStructure();
        } else {
            $data['unique_id'] = $transaction_id;
            $data['payment_method'] = $this->getPaymentMethodStructure();
        }

        return Helper::arrayStripNulls($data);
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
        return 'checkout/create';
    }

    /**
     * Creates our response
     *
     * @param  array   $data           Data from the response
     * @param  array   $headers        Headers from the response
     * @param  integer $code           The status code
     * @param  string  $status_reason  The status reason
     * @return PurchaseResponse
     */
    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
    {
        return $this->response = new PurchaseResponse($this, $data, $headers, $code, $status_reason);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(...$args)
    {
        // add our required parameters to the validate request
        $args = array_merge($args, $this->getRequiredParameters());
        call_user_func_array('parent::validate', $args);
    }
}
