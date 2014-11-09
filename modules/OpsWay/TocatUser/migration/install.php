<?php
/**
 * @var \OpsWay\AppManager\Service\Manager $this
 */

$console = $this->getServiceLocator()->get('console');

@copy(getcwd() . '/vendor/opsway/zfc-user-onelogin/config/zfcuser-onelogin.local.php.dist', getcwd() . '/config/autoload/local/onelogin.local.php');

$console->writeLine('Onelogin configuration file created!');
