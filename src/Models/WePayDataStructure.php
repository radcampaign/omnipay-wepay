<?php

namespace Omnipay\WePay\Models;

use Omnipay\WePay\Utilities\HasParametersTrait;
use Omnipay\WePay\Helper;
use \BadMethodCallException;

abstract class WePayDataStructure
{
    use HasParametersTrait;

    /**
     * Our class can be constructed with data
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Fills our data structure with data from an
     * array
     *
     * @param  array  $data
     * @return $this
     */
    public function fill(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    /**
     * Retrieves the accepted parameters
     *
     * @return array
     */
    public function getAcceptedParameters()
    {
        if (method_exists($this, 'contextParameters')) {
            return array_keys($this->contextParameters());
        }

        if (property_exists($this, 'parameters')) {
            return $this->parameters;
        }

        return [];
    }

    /**
     * Easy way to set the parameter on a class
     *
     * <code>
     *   $obj = new WePayDataStructure();
     *   $obj->account_id = 123456;
     * </code>
     *
     * @param string $name  the name of the parameter to set
     * @param mixed $value  any sort of data that we are setting
     *
     * @return  $this
     *
     * @throws  BadMethodCallException  if the property is not accepted for the class
     */
    public function __set($name, $value = null)
    {
        $accepted = $this->getAcceptedParameters();

        // first, check if there is a setter method that can satisfy this
        // request
        $setter = Helper::getParameterSetter($name);
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        }

        // if no setter, lets make sure that it is a key that is in our
        // accepted keys
        if (in_array($name, $accepted)) {
            return $this->setParameter($name, $value);
        }

        throw new BadMethodCallException(sprintf('Call to undefined property %s::%s', __CLASS__, $name));
    }

    /**
     * Easy way to get the parameter on a class
     *
     * <code>
     *   $obj = new WePayDataStructure();
     *   $obj->account_id;
     *   // returns the account id set on the class
     * </code>
     *
     * @param string $name  the name of the parameter to set
     *
     * @return mixed    whatever the property is set to
     *
     * @throws BadMethodCallException  if the property is not accepted for the class
     */
    public function __get($name)
    {
        // first lets check to see if there is a getter method that
        // can satisfy this request
        $getter = Helper::getParameterGetter($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        // otherwise, lets make sure that it is one of our
        // accepted functions
        $accepted = $this->getAcceptedParameters();
        if (in_array($name, $accepted)) {
            return $this->getParameter($name);
        }

        throw new BadMethodCallException(sprintf('Call to undefined property %s::%s', __CLASS__, $name));
    }

    /**
     * Overload method to call setters and getters
     *
     * @param  [type] $method    [description]
     * @param  [type] $arguments [description]
     *
     * @return [type]            [description]
     */
    public function __call($method, $arguments)
    {
        $action = substr($method, 0, 3);
        if (in_array($action, ['get', 'set']) && strlen($method) > 3) {
            $accepted = $this->getAcceptedParameters();
            $param = Helper::snakeCase(substr($method, 3));
            if (!empty($param) && in_array($param, $accepted)) {
                switch ($action) {
                    case 'get':
                        return $this->getParameter($param);
                    case 'set':
                        return call_user_func_array([$this, 'setParameter'], [$param, $arguments[0] ?? null]);
                }
            }

            return null;
        }

        throw new BadMethodCallException(sprintf('Call to undefined method %s::%s', __CLASS__, $method));
    }

    public function toArray()
    {
        return $this->getParameters();
    }
}
