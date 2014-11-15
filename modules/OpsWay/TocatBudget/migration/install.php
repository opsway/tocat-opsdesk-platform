<?php
/**
 * @var \OpsWay\AppManager\Service\Manager $this
 */

$console = $this->getServiceLocator()->get('console');

$console->writeLine('OpsWay/TocatBudget was installed!');

/*
 * You can you this any valid PHP code and use $this as environment application manager \OpsWay\AppManager\Service\Manager
 * For example for getting ServiceLocator or Doctrine Entity Manager Or Scheme...
 */
