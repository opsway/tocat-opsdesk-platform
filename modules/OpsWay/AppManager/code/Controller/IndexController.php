<?php
namespace OpsWay\AppManager\Controller;

use OpsWay\AppManager\Service\Manager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Prompt\Line;
use RuntimeException;

class IndexController extends AbstractActionController
{
    /**
     * @var Manager
     */
    protected $_service;

    /**
     * @param Manager $service
     */
    public function __construct(Manager $service)
    {
        $this->_service = $service;
    }

    protected function checkConsole()
    {
        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }
    }

    public function updateAction()
    {
        $this->checkConsole();
        $results = [];
        foreach ($this->_service->installAll(['controller' => $this]) as $result) {
            $results[] = "Module {$result['module']} was install successfully.";
        }
        $this->_service->getEventManager()->clearListeners('update');
        $this->_service->updateAttachModules();
        foreach ($this->_service->updateAll() as $result) {
            $results[] = "Module {$result['module']} was update to version {$result['version']} successfully.";
        }

        return implode("\n", $results) . "\n";
    }

    public function installAction()
    {
        $this->checkConsole();
        $results = [];
        foreach ($this->_service->installAll(['controller' => $this]) as $result) {
            $results[] = "Module {$result['module']} was install successfully.";
        }

        return implode("\n", $results) . "\n";
    }
}
