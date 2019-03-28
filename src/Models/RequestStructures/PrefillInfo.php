<?php
/**
 * This model is used with WePay data structures
 * @see  https://developer.wepay.com/api/reference/structures#payments_prefill_info
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our PrefillInfo class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('PrefillInfo');
 * </code>
 */
class PrefillInfo extends AbstractRequestStructure
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'name',
        'email',
        'phone_number',
        'address'
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
