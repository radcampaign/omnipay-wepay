<?php

namespace Omnipay\WePay\Models\RequestStructures;

use Omnipay\WePay\Models\WePayDataStructure;
use Omnipay\WePay\Helper;

abstract class AbstractRequestStructure extends WePayDataStructure implements RequestStructureInterface
{
    /**
     * For our iterator
     * @var integer
     */
    private $iterator_pos = 0;

    /**
     * {@inheritdoc}
     */
    public function getRequiredParameters()
    {
        if ($this->resolvePropertyExistsAndIsArray('required_parameters')) {
            return $this->required_parameters;
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionalParameters()
    {
        if ($this->resolvePropertyExistsAndIsArray('optional_parameters')) {
            return $this->optional_parameters;
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAcceptedParameters()
    {
        $required = $this->getRequiredParameters();
        $optional = $this->getOptionalParameters();
        return array_merge($required, $optional);
    }

    /**
     * Checks if a property exists and if it does, enforces that it is an array
     *
     * @param  string $property the class property that we are looking for
     *
     * @return boolean
     *
     * @throws  \Exception  if the property exists but is not an array
     */
    private function resolvePropertyExistsAndIsArray($property = '')
    {
        if (property_exists($this, $property)) {
            if (!is_array($this->$property)) {
                throw new \Exception(sprintf("%s::required_parameters must be an array", get_called_class()));
            }
            return true;
        }

        return false;
    }

    /**
     * Retrieves data that represents our class. Ensures that our required parameters
     * are always present. But for non-required parameters, only includes them if they
     * have values set and are not null
     *
     * @return array
     */
    public function toArray()
    {
        $ret = [];
        $required = $this->getRequiredParameters();
        foreach ($required as $req) {
            $ret[$req] = $this->$req;
        }

        $optional = $this->getOptionalParameters();
        foreach ($optional as $option) {
            if ($this->hasParameter($option)) {
                $ret[$option] = $this->$option;
            }
        }

        return $ret;
    }

    /**
     * Used to satisy our JsonSerializable Interface
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        $required = $this->getRequiredParameters();
        foreach ($required as $req) {
            if (!$this->hasParameter($req)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return empty($this->getParameters());
    }

    /**
     * Our array Access methods
     */

    public function offsetExists($offset)
    {
        return $this->hasParameter($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getParameter($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->setParameter($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->parameters->remove($offset);
    }

    /**
     * Iterator Methods
     */
    public function rewind()
    {
        $this->iterator_pos = 0;
    }

    public function current()
    {
        $keys = $this->getAcceptedParameters();
        return $this->{$keys[$this->iterator_pos]};
    }

    public function key()
    {
        $keys = $this->getAcceptedParameters();
        return $keys[$this->iterator_pos];
    }

    public function next()
    {
        $this->iterator_pos++;
    }

    public function valid()
    {
        $keys = $this->getAcceptedParameters();
        return isset($keys[$this->iterator_pos]);
    }
}
