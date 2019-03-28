<?php
/**
 * Won't pass gateway tests but will work for requests.
 *
 */
namespace Omnipay\WePay\Utilities;

use BadMethodCallException;
use Omnipay\WePay\Helper;
use Omnipay\Common\Helper as OmniHelper;

trait LazyLoadParametersTrait
{

    /**
     * For classes that initialized with the initialize function
     * @param  array  $parameters an array of thigns to define on the object
     * @return $this
     */
    public function initialize(array $parameters = [])
    {
        // in case we want to use this in other classes
        // that don't get initialized with the initialize function
        // we'll check if the parent has the initialize function
        // before automatically invoking it
        if (method_exists(get_parent_class($this), 'initialize')) {
            parent::initialize($parameters); // creates the parameter bag
        }

        $accepted_parameters = $this->getAcceptedParameters();
        if (!empty($accepted_parameters)) {
            foreach ($parameters as $key => $value) {
                if (in_array($key, $accepted_parameters)) {
                    $method = 'set'.ucfirst(OmniHelper::camelCase($key));
                    // if the method exists, then it was already handled
                    // by the Omnipay\Common\Helper::initialize in parent::initialize
                    // so no need to call it again
                    if (!method_exists($this, $method)) {
                        $this->$method($value);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Retrieves the data that has been lazy loaded
     *
     * @param  array  $excludes  parameters that we may want to exclude
     * @return array
     */
    protected function getLazyLoadedData($excludes = [], $keepEmpty = true)
    {
        $accepted = $this->getAcceptedParameters();
        $ret = [];
        foreach ($accepted as $param) {
            if (!in_array($param, $excludes)) {
                $value = $this->getParameter($param);
                if (empty($value) && !$keepEmpty) {
                    continue;
                }

                $ret[$param] = $value;
            }
        }

        return $ret;
    }

    public function getAcceptedParameters()
    {
        // option A - use a function that returns an associative array
        // useful if you want to store information about each paramter - like
        // if the parameter is required
        // i.e. \Omnipay\WePay\Message\Request\Purchase
        if (method_exists($this, 'getDefaultAcceptedParameters')) {
            return array_keys($this->getDefaultAcceptedParameters());
        }

        // option B - use a property that is a single array
        if (property_exists($this, 'accepted_parameters')) {
            return $this->accepted_parameters;
        }

        // option C - don't use option A or option B and get nothing
        return [];
    }

    public function __call($method, $arguments = [])
    {
        // 1 determine if it is a set call or a get call
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
}
