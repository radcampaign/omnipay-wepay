<?php
/**
 * @file contains MakeRequestStructure class
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

class MakeRequestStructure extends AbstractCommand
{
    use UsesStubsTrait,
        BaseDirectoryAwareTrait,
        WritesFilesTrait;

    /**
     * The name of the command for the command line
     * @var string
     */
    protected $name = 'make:request-structure';

    /**
     * An example of how to run the command
     *
     * @var string
     */
    protected $example = 'php artisan make:request-structure [Structure Name]';

    /**
     * A description of the command like what it does
     *
     * @var string
     */
    protected $description = 'Creates a data structure file for a command';

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
            $this->writeLine(sprintf(
                'You must tell us the name of the new command. I.E. `%s`',
                $this->example)
            );
            return;
        }

        $this->command_name = $name;

        $contents = $this->getAlteredStubContents('DataStructure');
        $location = $this->getStructureFilePath();
        $this->writeFile($location, $contents);

        $this->log(sprintf("Created Data Structure for %s", $this->getStructureClassName()));
        $this->log(
            sprintf(
                "Written to %s",
                ltrim(str_replace(
                    getcwd(), "", $location
                ), "/")
            )
        );
    }

    protected function getFileName()
    {
        $fileName = $this->command_name;
        if (substr($fileName, -4) === '.php') {
            return $fileName;
        }
        return $fileName . '.php';
    }

    protected function getStructureClassName()
    {
        $fileName = $this->command_name;
        if (substr($fileName, -4) === '.php') {
            return substr($string, 0, strlen($fileName) - 4);
        }

        return $fileName;
    }

    protected function getStructureFilePath()
    {
        return join(DIRECTORY_SEPARATOR, [$this->getBaseDirectory(), 'src', 'Models', 'RequestStructures', $this->getFileName()]);
    }

    protected function getAlteredStubContents($name = '')
    {
        $contents = $this->getStubContents($name);
        $this->replaceDataStructureNameHash($contents, $this->getStructureClassName());
        $this->addPHPTag($contents);

        return $contents;
    }
}
