<?php
/**
 * A helper trait that sets a class up with a parameter bag and ways
 * to set parameters and retrieve parameters
 */
namespace Omnipay\WePay\Utilities;

use Symfony\Component\HttpFoundation\ParameterBag;

trait HasParametersTrait
{
    /**
     * Storage for our parameter bag
     * @var Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameter_bag = null;

    /**
     * Gets all of the parameters
     * @return array
     */
    public function getParameters()
    {
        $bag = $this->_getBag();
        return $bag->all();
    }

    /**
     * Retrieves a value from our parameterbag
     * @param  string $key  the key to retrieved
     * @return mixed
     */
    public function getParameter($key = '')
    {
        $bag = $this->_getBag();
        return $bag->get($key);
    }

    /**
     * Sets the key and value to our parameter bag
     * @param string $key   the key for the value
     * @param mixed $value
     */
    public function setParameter($key = '', $value = null)
    {
        $bag = $this->_getBag();
        $bag->set($key, $value);
        return $this;
    }

    /**
     * Checks that a parameter is set on our paramter back
     *
     * @param  string  $key
     * @return boolean
     */
    public function hasParameter($key = '')
    {
        $bag = $this->_getBag();
        return $bag->has($key);
    }

    /**
     * Determines if the bag has been initialized,
     * and if not it creates a new ParameterBag
     * @return Symfony\Component\HttpFoundation\ParameterBag
     */
    // phpcs:ignore
    protected function _getBag()
    {
        if (is_null($this->parameter_bag)) {
            $this->parameter_bag = new ParameterBag;
        }

        return $this->parameter_bag;
    }
}
