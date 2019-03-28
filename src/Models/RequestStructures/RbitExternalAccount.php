<?php
/**
 * This model is used with WePay data structures
 * @see  https://developer.wepay.com/api/reference/structures
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

/**
 * Our RbitExternalAccount class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('RbitExternalAccount');
 * </code>
 */
class RbitExternalAccount extends AbstractRequestStructure implements RbitPropertiesInterface
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'is_partner_account', // string: yes or no
        'account_type', //
    ];

    /**
     * Defines the parameters for the model that are optional
     *
     * @var array
     */
    protected $optional_parameters = [
        'user_id',
        'uri',
        'create_time',
        'modify_time',
        'following',
        'followers',
        'connections',
        'feedback_scores_provided',
        'feedback_score_percent_positive',
        'feedback_average_score',
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
