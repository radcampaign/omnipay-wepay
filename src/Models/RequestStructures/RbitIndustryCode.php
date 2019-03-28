<?php
/**
 * This model is used with WePay data structures
 * @see https://developer.wepay.com/api/reference/rbit_types#industry_code
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our RbitIndustryCode class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('RbitIndustryCode');
 * </code>
 */
class RbitIndustryCode extends AbstractRequestStructure implements RbitPropertiesInterface
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'industry_code_type', // mcc, sic or naics
        'industry_code',
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'industry_detail',
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
