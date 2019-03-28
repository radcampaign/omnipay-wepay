<?php
/**
 * This model is used with WePay data structures
 * @see https://developer.wepay.com/api/reference/rbit_types#partner_service
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our RbitPartnerService class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('RbitPartnerService');
 * </code>
 */
class RbitPartnerService extends AbstractRequestStructure implements RbitPropertiesInterface
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'service_name'
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'service_monthly_cost',
        'currency',
        'modules_used',
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
