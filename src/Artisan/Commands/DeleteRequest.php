<?php
/**
 * @file contains DeleteRequest class
 *
 * this command is used on the command line with `php artisan`. see Command::$name
 * and Command::$example for how to use.
 */
namespace Omnipay\WePay\Artisan\Commands;

use Omnipay\WePay\Artisan\AbstractCommand;
// helpful traits
use Omnipay\WePay\Artisan\UsesStubsTrait;
use Omnipay\WePay\Artisan\BaseDirectoryAwareTrait;
use Omnipay\WePay\Artisan\WritesFilesTrait;

class DeleteRequest extends AbstractCommand
{
    use UsesStubsTrait,
        BaseDirectoryAwareTrait,
        WritesFilesTrait;

    /**
     * The name of the command for the command line
     * @var string
     */
    protected $name = 'delete:request';

    /**
     * An example of how to run the command
     *
     * @var string
     */
    protected $example = 'php artisan delete:request [RequestName] --gateway=user';

    /**
     * A description of the command like what it does
     *
     * @var string
     */
    protected $description = 'This removes all of the pieces for a request.';

    /**
     * Arguments that this command may take
     * example:
     * <code>
     *     protected $arguments = [
     *          'gateway' => [
     *              'description' => 'The type of gateway. accepted gateways are: payment, user, account'
     *          ]
     *      ];
     * </code?
     * @type array
     */
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
            $this->writeLine('You must tell us the name of the request to delete. i.e ' . $this->example);
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

        $this->deleteRequest();
        $this->deleteResponse();
        $this->deleteTest();
        $this->deleteSuccessMock();
        $this->deleterrorMock();
    }

    protected function deleteFile($filepath)
    {
        $this->log(sprintf('Deleting %s', $filepath));

        if (is_file($filepath)) {
            unlink($filepath);
            return;
        }

        $this->warn("Could not find file " . $filepath . " for deletion");
    }

    protected function deleteRequest()
    {
        $location = $this->getNewRequestFileLocation();
        $this->deleteFile($location);
    }

    protected function deleteResponse()
    {
        $location = $this->getNewResponseFileLocation();
        $this->deleteFile($location);
    }

    protected function deleteTest()
    {
        $location = $this->getNewRequestTestFileLocation();
        $this->deleteFile($location);
    }

    protected function deleteSuccessMock()
    {
        $location = $this->getNewRequestSuccessMockFileLocation();
        $this->deleteFile($location);
    }

    protected function deleterrorMock()
    {
        $location = $this->getNewRequestErrorMockFileLocation();
        $this->deleteFile($location);
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

    protected function getAbstractFileLocation($start, $bits = [], $newFileName = '', $addPhpExtenstion = true)
    {
        if (empty($newFileName)) {
            throw new \Exception("new file name cannot be empty");
        }

        // create the directory if it doesn't exist
        $dir = join(DIRECTORY_SEPARATOR, array_merge([$start], $bits));

        if ($addPhpExtenstion) {
            $newFileName = $newFileName . '.php';
        }

        $newFile = join(DIRECTORY_SEPARATOR, [$dir, $newFileName]);

        return $newFile;
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
