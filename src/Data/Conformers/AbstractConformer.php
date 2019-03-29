<?php

namespace Omnipay\WePay\Data\Conformers;

use Omnipay\Common\CreditCard;
use Omnipay\WePay\Factories\RequestStructureFactory;

abstract class AbstractConformer implements ConformersInterface
{
    /**
     * Storage for our CrediCard
     *
     * @var CreditCard
     */
    protected $card = null;

    /**
     * Constucts our class by optionally setting our card
     * @param CreditCard|null $card [description]
     */
    public function __construct(CreditCard $card = null)
    {
        if (!is_null($card)) {
            $this->card = $card;
        }
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getStructureTag();

    /**
     * {@inheritdoc}
     */
    abstract public function conform();

    /**
     * {@inheritdoc}
     */
    public function setCard(CreditCard $card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * Retrieves the isntance credit card
     *
     * @return CreditCard|null
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Retrieves the request structure relevant to the conformer
     *
     * @param  string $tag
     * @return \Omnipay\WePay\Models\RequestStructures\RequestStructureInterface
     */
    protected function getStructure()
    {
        $tag = $this->getStructureTag();
        return RequestStructureFactory::create($tag);
    }
}
