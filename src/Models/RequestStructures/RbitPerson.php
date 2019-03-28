<?php
/**
 * This model is used with WePay data structures
 * @see https://developer.wepay.com/api/reference/rbit_types#person
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our RbitPerson class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('RbitPerson');
 * </code>
 */
class RbitPerson extends AbstractRequestStructure implements RbitPropertiesInterface
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'name', // the full name of the person
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'birthdate', // must be in YYYY-MM-DD format
        'role', // employee, fundraiser, fundraising_team_captain, other_third_party
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
