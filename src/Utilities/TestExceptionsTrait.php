<?php
/**
 * Tests for common Omnipay\Common exceptions
 */
namespace Omnipay\WePay\Utilities;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Helper trait to test some common Omnipay Exception
 * Example:
 * <code>
 *
 * class MyExampleTest
 * {
 *     use Omnipay\WePay\Utilities\TestExceptionsTrait;
 *
 *     public function testInvalidRequestException() {
 *         $this->expectInvalidRequestException();
 *
 *          // send a request that validates it's data
 *          $this->request->send();
 *     }
 * }
 *
 * </code>
 */
trait TestExceptionsTrait
{
    /**
     * Tests invalid exceptions
     */
    public function expectInvalidRequestException()
    {
        $this->expectException(InvalidRequestException::class);
    }
}
