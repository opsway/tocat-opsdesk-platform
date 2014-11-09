<?php
namespace OpsWay\AppManager\Provider\VersionStorage;

use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Config;

class ConfigProvider implements ProviderInterface
{
    protected $_config = [];

    public function __construct(array $config)
    {
        if (empty($config)) {
            throw new InvalidArgumentException('Method' . __METHOD__ . ' required non-empty params.');
        }
        $this->_config = $config;
    }

    /**
     * @return array|mixed
     */
    public function getVersions()
    {
        $versions = [];
        $versionFile = $this->_config['path_to_file_versions'];
        if (file_exists($versionFile) && is_writable($versionFile)) {
            /** @var string $versionFile */
            $versions = include $versionFile;
        }
        return $versions;
    }

    public function setVersions(array $versions)
    {
        $writer = new Config\Writer\PhpArray();
        $writer->setUseBracketArraySyntax(true);
        $writer->toFile($this->_config['path_to_file_versions'], new Config\Config($versions));
        @chmod($this->_config['path_to_file_versions'], 0666);
    }
}
