<?php
/**
 * @var \OpsWay\AppManager\Service\Manager $this
 */

$console = $this->getServiceLocator()->get('console');
//$console->clear();

/**
 * @var \Zend\Mvc\Controller\AbstractActionController $controller
 */
$controller = $e->getParam('controller');
$consoleParams = [];
parse_str($controller->getRequest()->getParam('params', ''), $consoleParams);

// SETUP LOCAL CONFIG
$localConfig = new \Zend\Config\Config(include(getcwd() . '/config/autoload/local.php.dist'), true);

$dbConfig = $localConfig->doctrine->connection->orm_default->params;

foreach (['host', 'port', 'user', 'password', 'dbname'] as $pName) {
    if (isset($consoleParams['db']) && isset($consoleParams['db'][$pName])) {
        $dbConfig->{$pName} = $consoleParams['db'][$pName];
    } else {
        $dbConfig->{$pName} = ($value = \Zend\Console\Prompt\Line::prompt(
            "DATABASE. Please enter {$pName} [" . $dbConfig->{$pName} . "]:",
            true,
            100
        )) ? $value : $dbConfig->{$pName};
    }
}

$writer = new \Zend\Config\Writer\PhpArray();
$writer->setUseBracketArraySyntax(true);
$writer->toFile(getcwd() . '/config/autoload/local/db.local.php', $localConfig);

$console->writeLine('Database configuration file created!');
