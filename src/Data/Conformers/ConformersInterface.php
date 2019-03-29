<?php

namespace Omnipay\WePay\Data\Conformers;

use Omnipay\Common\CreditCard;

interface ConformersInterface
{
    /**
     * Sets the credit card object
     *
     * @param CreditCard $card
     */
    public function setCard(CreditCard $card);

    /**
     * Conforms the credit card object into one of our
     * request structures by retrieving from our
     * credit card object the relevant data for our request structure.
     *
     * @return Omnipay\WePay\Models\RequestStructures\RequestStructureInterface
     */
    public function conform();

    /**
     * Used to retrieve that tag for the structure that is resolvable
     * by the RequestStructureFactory
     *
     * @return string
     */
    public function getStructureTag();
}
