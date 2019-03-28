<?php
/**
 * Provides stub for making commands
 */
namespace Omnipay\WePay\Artisan\Commands;

use Omnipay\WePay\Artisan\AbstractCommand;
use Omnipay\WePay\Artisan\Commander;
use Omnipay\WePay\Artisan\UsesStubsTrait;
use Omnipay\WePay\Artisan\BaseDirectoryAwareTrait;
use Omnipay\WePay\Artisan\WritesFilesTrait;

class MakeCommand extends AbstractCommand
{
    use UsesStubsTrait,
        BaseDirectoryAwareTrait,
        WritesFilesTrait;

    /**
     * Defines the name of the command
     * @var string
     */
    protected $name = 'make:command';

    protected $example = 'php artisan make:command [CommandName]';

    protected $description = 'Creates a shell for a command';

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
        $this->writeCommand();
    }

    protected function writeCommand()
    {
        $contents = $this->getAlteredStubContents('Command');
        $location = $this->getCommandFilePath();
        $this->writeFile($location, $contents);
        $this->log(sprintf("Created Data Structure for %s", $this->getCommandClassName()));
        $this->log(
            sprintf(
                "Written to %s",
                ltrim(str_replace(getcwd(), "", $location), "/")
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

    protected function getCommandFilePath()
    {
        return join(
            DIRECTORY_SEPARATOR,
            [
                $this->getBaseDirectory(),
                'src',
                'Artisan',
                'Commands',
                $this->getFileName()
            ]
        );
    }

    protected function getCommandClassName()
    {
        $fileName = $this->command_name;
        if (substr($fileName, -4) === '.php') {
            return substr($string, 0, strlen($fileName) - 4);
        }

        return $fileName;
    }

    protected function getAlteredStubContents($name = '', $addPhpTag = true)
    {
        $contents = $this->getStubContents($name);
        $this->replaceCommandHash($contents, $this->getCommandClassName());
        if ($addPhpTag) {
            $this->addPHPTag($contents);
        }

        return $contents;
    }
}
