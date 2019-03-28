<?php
/**
 * @file contains Faker class
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

class Faker extends AbstractCommand
{
    use UsesStubsTrait,
        BaseDirectoryAwareTrait,
        WritesFilesTrait;

    /**
     * The name of the command for the command line
     * @var string
     */
    protected $name = 'make:faker';

    /**
     * An example of how to run the command
     *
     * @var string
     */
    protected $example = 'php artisan make:faker [FakerName]';

    /**
     * A description of the command like what it does
     *
     * @var string
     */
    protected $description = 'Creates a Faker class that can be used in our Faker Factory.';

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
    protected $arguments = [];

    protected $command_name = '';

    public function handle()
    {
        $name = $this->getClArgument(0);

        if (empty($name)) {
            $this->writeLine(
                sprintf(
                    'You must tell us the name of the new command. I.E. `%s`',
                    $this->example
                )
            );
            return;
        }

        $this->command_name = $name;
        $this->writeFaker();
    }

    public function writeFaker()
    {
        $contents = $this->getAlteredStubContents('Faker');
        $location = $this->getFakerFilePath();
        $this->writeFile($location, $contents);
        $this->log(sprintf("Created Faker for %s", $this->getCommandClassName()));
        $this->log(
            sprintf(
                "Written to %s",
                ltrim(str_replace(getcwd(), "", $location), "/")
            )
        );
    }

    protected function getAlteredStubContents($name = '', $addPhpTag = true)
    {
        $contents = $this->getStubContents($name);
        $this->replaceFakerNameHash($contents, $this->getCommandClassName());
        if ($addPhpTag) {
            $this->addPHPTag($contents);
        }

        return $contents;
    }

    protected function getFakerFilePath()
    {
        return join(DIRECTORY_SEPARATOR, [$this->getBaseDirectory(), 'src', 'Fakers', $this->getFileName()]);
    }

    protected function getCommandClassName()
    {
        $fileName = $this->command_name;
        if (substr($fileName, -4) === '.php') {
            return substr($string, 0, strlen($fileName) - 4);
        }

        return $fileName;
    }

    protected function getFileName()
    {
        $fileName = $this->command_name;
        if (substr($fileName, -4) === '.php') {
            return $fileName;
        }
        return $fileName . '.php';
    }
}
