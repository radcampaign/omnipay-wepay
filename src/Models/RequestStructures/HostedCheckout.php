<?php
/**
 * This model is used with WePay data structures
 * @see https://developer.wepay.com/api/reference/structures#hosted_checkout
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our HostedCheckout class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('HostedCheckout');
 * </code>
 */
class HostedCheckout extends AbstractRequestStructure
{
    use HasAutoCaptureTrait;

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
        'redirect_uri',
        'mode',
        'fallback_uri',
        'shipping_fee',
        'require_shipping',
        'prefill_info',
        'funding_sources',
        'theme_object',
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
