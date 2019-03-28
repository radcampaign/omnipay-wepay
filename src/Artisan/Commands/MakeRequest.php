<?php

namespace Omnipay\WePay\Artisan\Commands;

use Omnipay\WePay\Artisan\AbstractCommand;
use Omnipay\WePay\Artisan\UsesStubsTrait;
use Omnipay\WePay\Artisan\BaseDirectoryAwareTrait;
use Omnipay\WePay\Artisan\WritesFilesTrait;

class MakeRequest extends AbstractCommand
{
    use UsesStubsTrait,
        BaseDirectoryAwareTrait,
        WritesFilesTrait;

    protected $name = 'make:request';

    protected $example = 'php artisan make:request [Name] --gateway=[gateway]';

    protected $description = 'Generates all of the things we need for a request';

    protected $arguments = [
        'gateway' => [
            'description' => 'The type of gateway. Accepted gateways are: payment, user, account'
        ]
    ];

    protected $requestName = '';

    protected $resonseName = '';

    protected $gatewayNamespaceName = '';

    protected $testName = '';

    protected $successMockName = '';

    protected $errorMockName = '';

    public function handle()
    {
        $type = $this->getCLOption('gateway');
        $name = $this->getCLArgument(0);

        if (empty($name)) {
            $this->writeLine('You must tell us the name of the new request. I.e NewRequest');
            return;
        }

        $allowedGates = ['payment', 'user', 'account'];
        if (empty($type) || !in_array($type, $allowedGates)) {
            $this->writeLine("You must set `--gateway` to either " . join(',', $allowedGates));
            return;
        }

        $this->requestName = $name;
        $this->gatewayNamespaceName = $this->getGateWayNamespace($type);
        $this->responseName = $name . 'Response';
        $this->testName = $this->setTestName();

        $this->successMockName = $this->setSuccessMockName();
        $this->errorMockName = $this->setErrorMockName();

        $this->writeRequest();
        $this->writeResponse();
        $this->writeTest();
        $this->writeSuccessMock();
        $this->writeErrorMock();
    }

    protected function reportLocation($location = '')
    {
        $this->log(
            sprintf(
                "    to %s",
                ltrim(str_replace(getcwd(), "", $location), "/")
            )
        );
    }

    protected function writeTest()
    {
        $contents = $this->getAlteredStubContents('RequestTest');
        $this->log(sprintf("Writing file: %s", $this->testName . '.php'));
        $location = $this->getNewRequestTestFileLocation();
        if ($location !== false) {
            $this->writeFile($location, $contents);
            $this->reportLocation($location);
        }
    }

    protected function writeRequest()
    {
        $contents = $this->getAlteredStubContents('Request');
        $this->log(sprintf("Writing file: %s", $this->requestName . '.php'));
        $location = $this->getNewRequestFileLocation();
        if ($location !== false) {
            $this->writeFile($location, $contents);
            $this->reportLocation($location);
        }
    }

    protected function writeResponse()
    {
        $contents = $this->getAlteredStubContents('Response');
        $this->log(sprintf("Writing file: %s", $this->responseName . '.php'));
        $location = $this->getNewResponseFileLocation();
        if ($location !== false) {
            $this->writeFile($location, $contents);
            $this->reportLocation($location);
        }
    }

    protected function writeSuccessMock()
    {
        $contents = $this->getAlteredStubContents('SuccessMock', false);
        $this->log(sprintf("Writing file: %s", $this->successMockName));
        $location = $this->getNewRequestSuccessMockFileLocation();
        if ($location !== false) {
            $this->writeFile($location, $contents);
            $this->reportLocation($location);
        }
    }

    protected function writeErrorMock()
    {
        $contents = $this->getAlteredStubContents('ErrorMock', false);
        $this->log(sprintf("Writing file: %s", $this->errorMockName));
        $location = $this->getNewRequestErrorMockFileLocation();
        if ($location !== false) {
            $this->writeFile($location, $contents);
            $this->reportLocation($location);
        }
    }

    protected function setTestName()
    {
        $name = ucfirst(rtrim($this->gatewayNamespaceName, '\\'));
        return $name . ucfirst($this->requestName) . 'Test';
    }

    protected function setSuccessMockName()
    {
        $name = ucfirst(rtrim($this->gatewayNamespaceName, '\\'));
        return $name . ucfirst($this->requestName) . 'Success.txt';
    }

    protected function setErrorMockName()
    {
        $name = ucfirst(rtrim($this->gatewayNamespaceName, '\\'));
        return $name . ucfirst($this->requestName) . 'Error.txt';
    }

    protected function getNewResponseFileLocation()
    {
        return $this->getGatewayFileLocation(['Message', 'Response'], $this->responseName);
    }

    protected function getNewRequestFileLocation()
    {
        return $this->getGatewayFileLocation(['Message', 'Request'], $this->requestName);
    }

    protected function getNewRequestTestFileLocation()
    {
        return $this->getAbstractFileLocation(
            $this->getTestBaseDir(),
            ['Message'],
            $this->testName
        );
    }

    protected function getNewRequestSuccessMockFileLocation()
    {
        return $this->getAbstractFileLocation(
            $this->getTestBaseDir(),
            ['Mock'],
            $this->successMockName,
            false
        );
    }

    protected function getNewRequestErrorMockFileLocation()
    {
        return $this->getAbstractFileLocation(
            $this->getTestBaseDir(),
            ['Mock'],
            $this->errorMockName,
            false
        );
    }

    protected function getGatewayFileLocation($bits = [], $newFileName = '')
    {
        $start = $this->getGatewayBaseDir();
        return $this->getAbstractFileLocation($start, $bits, $newFileName);
    }

    protected function getAbstractFileLocation($start, $bits = [], $newFileName = '', $addPhpExtenstion = true)
    {
        if (empty($newFileName)) {
            throw new \Exception("new file name cannot be empty");
        }

        // create the directory if it doesn't exist
        $dir = join(DIRECTORY_SEPARATOR, array_merge([$start], $bits));
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if ($addPhpExtenstion) {
            $newFileName = $newFileName . '.php';
        }
        $newFile = join(DIRECTORY_SEPARATOR, [$dir, $newFileName]);
        if (file_exists($newFile)) {
            $this->error(sprintf("File at %s already exists! skipping ...", $newFile));
            return false;
        }

        return $newFile;
    }


    protected function getGatewayBaseDir()
    {
        $namespace = rtrim($this->gatewayNamespaceName, '\\');
        $start = $this->getBaseDirectory() . DIRECTORY_SEPARATOR . 'src';
        if (!empty($namespace)) {
            $start .= DIRECTORY_SEPARATOR . $namespace;
        }
        return $start;
    }

    protected function getTestBaseDir()
    {
        return join(DIRECTORY_SEPARATOR, [$this->getBaseDirectory(), 'tests']);
    }

    protected function getAlteredStubContents($name = '', $addPhpTag = true)
    {
        $contents = $this->getStubContents($name);
        $this->replaceGatewayHash($contents, $this->gatewayNamespaceName);
        $this->replaceRequestNameHash($contents, $this->requestName);
        $this->replaceResponseNameHash($contents, $this->responseName);
        $this->replaceTestNameHash($contents, $this->testName);
        $this->replaceSuccesMockHash($contents, $this->successMockName);
        $this->replaceErrorMockHash($contents, $this->errorMockName);
        if ($addPhpTag) {
            $this->addPHPTag($contents);
        }
        return $contents;
    }

    protected function getGateWayNamespace($type)
    {
        switch ($type) {
            case 'user':
                return 'User\\';
            case 'account':
                return 'Account\\';
            default:
                return '';
        }
    }
}
