<?php
/**
 * This model is used with WePay data structures
 * @see https://developer.wepay.com/api/reference/structures#payment_method
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our PaymentMethod class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('PaymentMethod');
 * </code>
 */
class PaymentMethod extends AbstractRequestStructure
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'type'
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'inline_credit_card',
        'credit_card',
        'payment_bank',
        'preapproval'
    ];

    /**
     * Determines how the class should be rendered as an array
     *
     * @see Omnipay\WePay\Utilities\ArrayableInterface
     *
     * @return array
     */
    public function toArray()
    {
        // input rules for how this class should be
        // rendered as an array or just delete the function
        // and let it default to the parent's toArray
        return parent::toArray();
    }
}
