<?php

namespace Omnipay\WePay;

use PHPUnit\Framework\TestCase;
use Omnipay\WePay\Factories\RequestStructureFactory;
use Omnipay\WePay\Factories\FakerFactory;
use Omnipay\WePay\Models\RequestStructures\RequestStructureInterface;

class RequestStructureTest extends TestCase
{
    public function testFactory()
    {
        $list = RequestStructureFactory::listModels();
        $this->assertNotEmpty($list);

        $listRbits = RequestStructureFactory::listRbitModels();
        $this->assertNotEmpty($listRbits);
    }

    public function testAddressModel()
    {
        $model = RequestStructureFactory::create('Address');
        $this->assertRSInterface($model);

        $params = $model->getAcceptedParameters();
        $this->assertNotEmpty($params);

        $data = FakerFactory::create('address')->fake();
        foreach ($data as $key => $value) {
            $model->$key = $value;
            $this->assertSame($value, $model->$key);
        }
    }

    protected function assertRSInterface($obj)
    {
        return $this->assertInstanceOf(RequestStructureInterface::class, $obj);
    }
}
