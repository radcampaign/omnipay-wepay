<?php
/**
 * This model is used with WePay data structures. Even though RBits in WePay
 * are treated differently than request structures, it's really just another data
 * structure so we will treat it similarly here
 *
 * @see https://developer.wepay.com/api/reference/rbit_types
 *
 */
namespace Omnipay\WePay\Models\RequestStructures;

use Omnipay\WePay\Factories\RequestStructureFactory;
use InvalidArgumentException;

/**
 * Our Rbit class.
 *
 * Can be invoked via the RequestStructureFactory like so:
 *
 * <code>
 *     use Omnipay\WePay\Factories\RequestStructureFactory;
 *
 *     $model = RequestStructureFactory::create('Rbit');
 * </code>
 */
class Rbit extends AbstractRequestStructure
{
    /**
     * Defines the parameters for the model that
     * are required
     *
     * @var array
     */
    protected $required_parameters = [
        'type',
        'properties',
        'receive_time',
        'source'
    ];

    /**
     * Defines the parameters for the model that are optional. The WePay
     * documentation notes that these are required but I think that when rbits
     * are passed bundled with other requests, the WePay api fills them in for
     * us
     *
     * @var array
     */
    protected $optional_parameters = [
        'associated_object_type',
        'associated_object_id'
    ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // by default, lets set the recieve time to the current time
        // in case a recieve time doesnt get set
        if (!$this->hasParameter('recieve_time')) {
            $this->receive_time = time();
        }
    }

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

    /**
     * This class's parameters properties can be any value but if you want a
     * guide, you can use one of our known rbit data structures for a type.
     * This
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function getTypePropertiesModel($data = [])
    {
        if (!$this->hasParameter('type')) {
            throw new \Exception("Must set first type");
        }

        $tag = $this->getType();

        try {
            return RequestStructureFactory::rbitCreate($tag, $data);
        } catch (\InvalidArgumentException $error) {
            throw new InvalidArgumentException(sprintf("Could not find a model for type %s", $tag));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        // type needs to be set
        if (!parent::isValid()) {
            return false;
        }

        return $this->typeIsSupported();
    }

    /**
     * checks if the type is supported
     *
     * @return boolean
     */
    public function typeIsSupported()
    {
        // now lets validate our type
        try {
            $this->getTypepropertiesModel();
            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }
}
