<?php

namespace Omnipay\WePay\Artisan;

trait UsesStubsTrait {
    /**
     * Storage for our stub path directory
     * @var string
     */
    protected $stubPath = '';

    /**
     * Retrieves the stub path
     * @return string
     */
    protected function getStubPath()
    {
        if (empty($this->stubPath)) {
            $baseDir = defined('ARTISAN_BASE_DIR') ? ARTISAN_BASE_DIR : getcwd();
            $this->stubPath = join(DIRECTORY_SEPARATOR,
                [
                    $baseDir,
                    'stubs'
                ]
            );
        }

        return $this->stubPath;
    }

    /**
     * Gets the stub file path
     * @param  string $name the file name of the stub without .stub
     * @return string
     */
    protected function getStub($name = '')
    {
        // add our .stub extension if it is not present
        if (substr($name, -5) !== '.stub') {
            $name .= '.stub';
        }

        $stubFile = join(DIRECTORY_SEPARATOR, [$this->getStubPath(), $name]);
        if (!is_file($stubFile)) {
            throw new \Exception('Could not get stub path: ' . $stubFile);
        }

        return $stubFile;
    }

    /**
     * Get contents for a stub file and runs our hash replacements on it
     * @param  string $name
     * @return
     */
    protected function getStubContents($name = '')
    {
        $stubFile = $this->getStub($name);
        return file_get_contents($stubFile);
    }

    /**
     * Writes a php tag at the begining of any stub contents
     * @param string &$contents altered via pass-by-reference - the contents of a stub file
     */
    protected function addPHPTag(&$contents = '')
    {
        $contents = "<?php\n" . $contents;
    }

    /*
        These are the hash functions that will replace hashes that stubs may contain
     */

    /**
     * Replaces #{TESTNAME} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceTestNameHash(&$contents = '', $string = '')
    {
        $contents = str_replace('#{TESTNAME}', $string, $contents);
    }

    /**
     * Replaces #{SUCCESSMOCK} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceSuccesMockHash(&$contents = '', $string = '')
    {
        $contents = str_replace('#{SUCCESSMOCK}', $string, $contents);
    }

    /**
     * Replaces #{ERRORMOCK} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceErrorMockHash(&$contents = '', $string = '')
    {
        $contents = str_replace('#{ERRORMOCK}', $string, $contents);
    }

    /**
     * Replaces #{GATEWAY} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceGatewayHash(&$contents = '', $string = '')
    {
        $contents = str_replace('#{GATEWAY}', $string, $contents);
    }

    /**
     * Replaces #{REQUEST} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceRequestNameHash(&$contents = '', $string = '')
    {
        $contents = str_replace('#{REQUEST}', $string, $contents);
    }

    /**
     * Replaces #{RESPONSE} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceResponseNameHash(&$contents = '', $string)
    {
        $contents = str_replace('#{RESPONSE}', $string, $contents);
    }

    /**
     * Replaces #{COMMAND} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceCommandHash(&$contents = '', $string)
    {
        $contents = str_replace('#{COMMAND}', $string, $contents);
    }

    /**
     * Replaces #{DSNAME} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceDataStructureNameHash(&$contents = '', $string)
    {
        $contents = str_replace('#{DSNAME}', $string, $contents);
    }

    /**
     * Replaces #{FAKER} with the name of the test name
     *
     * @param  string &$contents the contents to search and replace a hash for
     * @param  string $string    the string to replace the hash with
     * @return void              contents altered with pass-by-reference
     */
    protected function replaceFakerNameHash(&$contents = '', $string)
    {
        $contents = str_replace('#{FAKER}', $string, $contents);
    }
}
