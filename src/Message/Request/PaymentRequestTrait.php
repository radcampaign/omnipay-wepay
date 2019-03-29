<?php

namespace Omnipay\WePay\Message\Request;

use Omnipay\WePay\Helper;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\WePay\Factories\RequestStructureFactory;

/**
 * trait PaymentRequestTrait contains setters and getters
 * that are useful to a payment requests
 */
trait PaymentRequestTrait
{
    public function getFeePayer()
    {
        return $this->getParameter('fee_payer');
    }

    public function setFeePayer($value)
    {
        return $this->setParameter('fee_payer', $value);
    }

    public function getApplicationFee()
    {
        return $this->getParameter('application_fee');
    }

    public function setApplicationFee($value)
    {
        return $this->setParameter('application_fee', $value);
    }

    public function getType()
    {
        return $this->getParameter('type');
    }

    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('account_id');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('account_id', $value);
    }

    public function getRegion()
    {
        return $this->getParameter('region');
    }

    public function setRegion($value)
    {
        return $this->setParameter('region', $value);
    }

    public function getMode()
    {
        return $this->getParameter('mode');
    }

    public function setMode($value)
    {
        return $this->setParameter('mode', $value);
    }

    public function getFallbackUri()
    {
        return $this->getParameter('fallback_uri');
    }

    public function setFallbackUri($value)
    {
        return $this->setParameter('fallback_uri', $value);
    }

    public function getCallbackUri()
    {
        return $this->getParameter('callback_uri');
    }

    public function setCallbackUri($value)
    {
        return $this->setParameter('callback_uri', $value);
    }

    public function getShippingFee()
    {
        return $this->getParameter('shipping_fee');
    }

    public function setShippingFee($value)
    {
        return $this->setParameter('shipping_fee', $value);
    }

    public function getRequireShipping()
    {
        return $this->getParameter('require_shipping');
    }

    public function setRequireShipping($value)
    {
        return $this->setParameter('require_shipping', $value);
    }

    public function getFundingSources()
    {
        return $this->getParameter('funding_sources');
    }

    public function setFundingSources($value)
    {
        return $this->setParameter('funding_sources', $value);
    }

    public function getTransactionReference()
    {
        return $this->getParameter('transaction_reference');
    }

    public function setTransactionReference($value)
    {
        return $this->setParameter('transaction_reference', $value);
    }

    public function getRefundReason()
    {
        return $this->getParameter('refund_reason');
    }

    public function setRefundReason($value)
    {
        return $this->setParameter('refund_reason', $value);
    }

    public function getCancelReason()
    {
        return $this->getParameter('cancel_reason');
    }

    public function setCancelReason($value)
    {
        return $this->setParameter('cancel_reason', $value);
    }

    public function getPaymentMethodType()
    {
        return $this->getParameter('payment_method_type');
    }

    /**
     * Sets the payment method type
     *
     * @param string $value accepted types are payment_bank, credit_card, inline_credit_card, preapproval
     */
    public function setPaymentMethodType($value)
    {
        return $this->setParameter('payment_method_type', $value);
    }

    /**
     * Set auto capture
     *
     * @param boolean $value
     */
    public function setAutoCapture(bool $value)
    {
        return $this->setParameter('auto_capture', $value);
    }

    /**
     * Defaults to true
     *
     * @return boolean
     */
    public function getAutoCapture()
    {
        return $this->getParameter('auto_capture');
    }

    /**
     * Sets the auto release value
     *
     * @param boolean $value
     */
    public function setAutoRelease(bool $value)
    {
        return $this->setParameter('auto_release', $value);
    }

    /**
     * Retrieves the auto_release parameter - Defaults to true
     *
     * @return boolean
     */
    public function getAutoRelease()
    {
        return $this->getParameter('auto_release') ?? true;
    }

    /**
     * get CC Callback Uri for IPNs on changes to cc
     *
     * @return string
     */
    public function getCcCallbackUri()
    {
        return $this->getParameter('cc_callback_uri');
    }

    /**
     * Use this to set the cc callback uri for IPN notifications to changes
     * in WePay stored credit cards
     *
     * @param string $value
     */
    public function setCcCallbackUri($value)
    {
        return $this->setParameter('cc_callback_uri', $value);
    }

    /**
     * Sets initiated by - possibly values: custom, merchant
     *
     * @param $this
     */
    public function setInitiatedBy($value)
    {
        return $this->setParameter('initiated_by', $value);
    }

    /**
     * Retrieves the initiated_by parameter
     *
     * @return string
     */
    public function getInitiatedBy()
    {
        return $this->getParameter('initiated_by');
    }

    public function setDeliveryType($value)
    {
        return $this->setParameter('delivery_type', $value);
    }

    /**
     * retrieves the delivery type parameter
     * possible values: fully_delivered, point_of_sale, shipping, donation,
     * subscription, partial_prepayment, full_prepayment
     *
     * @return string
     */
    public function getDeliveryType()
    {
        return $this->getParameter('delivery_type');
    }

    /**
     * Checks if the callback uri is not empty
     *
     * @return boolean
     */
    protected function hasCallbackUri()
    {
        return !empty($this->getCallbackUri());
    }

    /**
     * Gets the fee structure
     *
     * @see    https://developer.wepay.com/api/reference/structures#fee
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    protected function getFeeStructure()
    {
        return RequestStructureFactory::create(
            'Fee',
            Helper::arrayStripNulls([
                'fee_payer' => $this->getFeePayer(),
                'app_fee'   => $this->getApplicationFee()
            ])
        );
    }

    /**
     * If the token is not set, then we are processing a hosted checkout
     *
     * @return boolean
     */
    protected function isHostedCheckout()
    {
        return empty($this->getToken());
    }

    /**
     * Checks to see if the card is not empty
     *
     * @return boolean
     */
    protected function hasCard()
    {
        return !empty($this->getCard());
    }

    /*
        Some useful retrieval functions for known WePay data structures
     */

    /**
     * @see https://developer.wepay.com/api/reference/structures#hosted_checkout
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getHostedCheckoutStructure()
    {
        $hosted_info = RequestStructureFactory::create(
            'HostedCheckout',
            Helper::arrayStripNulls([
                'redirect_uri'     => $this->getReturnUrl(),
                'mode'             => $this->getMode(),
                'fallback_uri'     => $this->getFallbackUri(),
                'shipping_fee'     => $this->getShippingFee(),
                'require_shipping' => $this->getRequireShipping(),
                'funding_sources'  => $this->getFundingSources()
            ])
        );

        $prefill_info = $this->getPaymentsPrefillInfoStructure();
        if (!$prefill_info->isEmpty()) {
            $hosted_info->prefill_info = $prefill_info;
        }

        return $hosted_info;
    }

    /**
     * Gets a payments prefill info structure
     *
     * @see  https://developer.wepay.com/api/reference/structures#payments_prefill_info
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getPaymentsPrefillInfoStructure()
    {
        if (!$this->hasCard()) {
            return RequestStructureFactory::create('PrefillInfo');
        }

        $card = $this->getCard();
        $address = $this->getAddressStructure();

        return RequestStructureFactory::create(
            'PrefillInfo',
            Helper::arrayStripNulls([
                'name'         => $card->getName(),
                'email'        => $card->getName(),
                'phone_number' => $card->getPhone(),
                'address'      => empty($address) ? null : $address,
            ])
        );
    }

    /**
     * gets the address structure
     *
     * @see  https://developer.wepay.com/api/reference/structures#address
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getAddressStructure()
    {
        if (!$this->hasCard()) {
            return ;
        }

        $card = $this->getCard();
        return RequestStructureFactory::create(
            'Address',
            Helper::arrayStripNulls([
                'address1'    => $card->getAddress1(),
                'address2'    => $card->getAddress2(),
                'city'        => $card->getCity(),
                'region'      => $card->getState(),
                'country'     => $card->getCountry(),
                'postal_code' => $card->getPostcode()
            ])
        );
    }

    /**
     * Retrieves the payment method structure
     *
     * @see  https://developer.wepay.com/api/reference/structures#payment_method
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getPaymentMethodStructure()
    {
        $type = $this->getPaymentMethodType();

        $ret_data = RequestStructureFactory::create('PaymentMethod', compact('type'));

        switch ($type) {
            case 'payment_bank':
                $ret_data->payment_bank = $this->getPaymentBankStructure();
                break;
            case 'inline_credit_card':
                $ret_data->inline_credit_card = $this->getInlineCreditCardStructure();
                break;
            case 'preapproval':
                $ret_data->preapproval = $this->getPreapprovalStructure();
                break;
            default:
                if ($this->hasParameter('token')) {
                    $ret_data->type = 'credit_card';
                    $ret_data->credit_card = $this->getCreditCardStructure();
                    break;
                }
                throw new InvalidRequestException(sprintf("Payment method of type %s is not supported", $type));
        }

        return $ret_data;
    }

    /**
     * Retrieves the payment bank structure
     *
     * @see  https://developer.wepay.com/api/reference/structures#payment_bank
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getPaymentBankStructure()
    {
        return RequestStructureFactory::create('PaymentBank', [
            'id' => $this->getToken()
        ]);
    }

    /**
     * Retrieves the credit card structure
     *
     * @see  https://developer.wepay.com/api/reference/structures#credit_card
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getCreditCardStructure()
    {
        return RequestStructureFactory::create(
            'CreditCard',
            Helper::arrayStripNulls([
                'id'        => $this->getToken(),
                'auto_capture' => $this->getAutoCapture()
            ])
        );
    }

    /**
     * Retrieves the inline credit card structure
     *
     * @see  https://developer.wepay.com/api/reference/structures#inline_credit_card_request
     * @return \Omnipay\WePay\Models\RequestStructure\RequestStructureInterface
     */
    public function getInlineCreditCardStructure()
    {
        if (!$this->hasCard()) {
            return RequestStructureFactory::create('InlineCreditCard', []);
        }

        $card = $this->getCard();

        $address = $this->getAddressStructure();

        return RequestStructureFactory::create(
            'InlineCreditCard',
            Helper::arrayStripNulls([
                'cc_number'         => $card->getNumber(),
                'expiration_month'  => $card->getExpiryMonth(),
                'expiration_year'   => $card->getExpiryYear(),
                'user_name'         => $card->getName(),
                'email'             => $card->getEmail(),
                'address'           => $address,
                'reference_id'      => $this->getToken(),
                'cvv'               => $card->getCvv(),
                'auto_capture'      => $this->getAutoCapture(),
                'auto_update'       => $this->getAutoUpdateCc(),
                'callback_uri'      => $this->getCcCallbackUri()
            ])
        );
    }
}
