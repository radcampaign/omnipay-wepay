<?php
/**
 * This model is used with WePay data structures
 * @see https://developer.wepay.com/api/reference/structures#inline_credit_card_request
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our InlineCreditCard class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('InlineCreditCard');
 * </code>
 */
class InlineCreditCard extends AbstractRequestStructure
{
    use HasAutoCaptureTrait;

    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'cc_number',
        'expiration_month',
        'expiration_year',
        'user_name',
        'email',
        'address',
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'cvv',
        'reference_id',
        'auto_capture',
        'auto_update',
        'callback_uri',
        'virtual_terminal',
        'payment_request_flag',
        'recurring',
        'card_on_file',
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
