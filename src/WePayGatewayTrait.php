<?php
/**
 * All of our gateways should have these methods
 */

namespace Omnipay\WePay;

use Omnipay\WePay\Factories\RequestStructureFactory;

trait WePayGatewayTrait
{
    use RouterHooksTestModeTrait,
        WePayDefaultGettersAndSettersTrait;

    /**
     * Defining as a class variable our default parameters
     * @var array
     */
    protected $default_parameters = [
        'access_token' => '',
        'client_id' => '',
        'client_secret' => ''
    ];

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        $defaults = $this->default_parameters;
        if (property_exists($this, 'added_parameters') && is_array($this->added_parameters)) {
            $defaults = array_merge($defaults, $this->added_parameters);
        }
        return $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'wepay';
    }

    public function createRbit(array $data = [])
    {
        return RequestStructureFactory::rbitCreate('', $data);
    }

    public function createRbitProperties(string $tag, array $data = [])
    {
        return RequestStructureFactory::rbitCreate($tag, $data);
    }

    public function getRequestStructure($tag = '', array $data = [])
    {
        return RequestStructureFactory::create($tag, $data);
    }
}
