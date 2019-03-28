<?php
/**
 * A quick trait for models that have the auto_capture paramter
 * auto_capture is a boolean that defaults to true
 */
namespace Omnipay\WePay\Models\RequestStructures;

trait HasAutoCaptureTrait
{
    /**
     * Retrieves the Auto Capture parameter. Auto Capture defaults
     * to true
     *
     * @return boolean
     */
    public function getAutoCapture()
    {
        return $this->getParameter('auto_capture') ?? true;
    }

    public function setAutoCapture(bool $value)
    {
        return $this->setParameter('auto_capture', $value);
    }
}
