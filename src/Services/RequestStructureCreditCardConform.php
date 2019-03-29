<?php
/**
 * This service takes a \Omnipay\Common\CreditCard object
 * and conforms it to a known request structure
 * using conformers found in src/Services/CCConformers.
 */
namespace Omnipay\WePay\Services;

use Omnipay\WePay\Helper;
use Omnipay\Common\CreditCard;
use Omnipay\WePay\Data\Conformers\ConformersInterface;

class RequestStructureCreditCardConform implements ServiceInterface
{
    /**
     * The namespace from where the conformers exist
     *
     * @var string
     */
    protected static $namespace = '\\Omnipay\\WePay\\Data\\Conformers\\';

    /**
     * Storage for the Request Structure Tag
     * @var string
     */
    protected $rs_tag = '';

    /**
     * Storage for the CrediCard
     * @var CreditCard
     */
    protected $card = null;

    /**
     * Creates our service
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * [create description]
     * @param  string     $rs_tag [description]
     * @param  CreditCard $card   [description]
     * @return [type]             [description]
     */
    public function invoke()
    {
        $rs_tag = Helper::paramMethodized($this->getRSTag());
        if (empty($rs_tag)) {
            throw new \Exception("Must set the Request Structure tag using setRSTag");
        }

        $card = $this->getCreditCard();
        if (empty($card)) {
            throw new \Exception("Must set the CreditCard object using setCard");
        }

        $class = self::$namespace . $rs_tag;
        if (!class_exists($class)) {
            throw new \Exception("Conformer for $rs_tag does not exist");
        }

        if (!self::classImplementsInterface($class)) {
            throw new \Exception("Found $class but fails to implement our ConformersInterface");
        }

        $obj = new $class;
        $obj->setCard($card);
        return $obj->conform();
    }

    public function getRSTag()
    {
        return $this->rs_tag;
    }

    public function setRSTag(string $rs_tag = '')
    {
        $this->rs_tag = $rs_tag;
        return $this;
    }

    public function getCreditCard()
    {
        return $this->card;
    }

    public function setCreditCard(CreditCard $card)
    {
        $this->card = $card;
        return $this;
    }

    public static function classImplementsInterface($class = '')
    {
        return in_array(ConformersInterface::class, class_implements($class));
    }
}
