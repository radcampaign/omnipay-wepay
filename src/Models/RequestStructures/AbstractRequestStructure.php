<?php

namespace Omnipay\WePay\Models\RequestStructures;

use Omnipay\WePay\Models\WePayDataStructure;
use Omnipay\WePay\Helper;

abstract class AbstractRequestStructure extends WePayDataStructure implements RequestStructureInterface
{
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
     * For car dump - gets the data from toArray to dump out as the
     * representation of our object
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->toArray();
    }
}
