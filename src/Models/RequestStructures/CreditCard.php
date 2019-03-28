<?php
/**
 * This model is used with WePay data structures
 * @see  https://developer.wepay.com/api/reference/structures
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our CrediCard class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('CrediCard');
 * </code>
 */
class CreditCard extends AbstractRequestStructure
{
    use HasAutoCaptureTrait;

    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'id',
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'data',
        'auto_capture'
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
