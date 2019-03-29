<?php

namespace Omnipay\WePay\Models\RequestStructures;

use Omnipay\WePay\Utilities\ArrayableInterface;
use JsonSerializable;

interface RequestStructureInterface extends ArrayableInterface, JsonSerializable
{
    /**
     * Retrieves a list of all of the accepted parameters for the model
     *
     * @return array
     */
    public function getAcceptedParameters();

    /**
     * Retrieves all of the required parameters;
     *
     * @return array
     */
    public function getRequiredParameters();

    /**
     * Retrieves all of the optional parameters
     *
     * @return array
     */
    public function getOptionalParameters();

    /**
     * Checks to make sure that the request data for this structure is valid
     * and thus ready to be sent
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Checks to see if the request data is empty
     *
     * @return boolean
     */
    public function isEmpty();

    /**
     * Fills our request structure wtih data
     *
     * @param  array  $data
     * @return $this
     */
    public function fill(array $data = []);

}
