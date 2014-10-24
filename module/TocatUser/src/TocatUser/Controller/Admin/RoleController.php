<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TocatUser\Controller\Admin;

use TocatUser\Service\RoleService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{
    /**
     * @var RoleService
     */
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        return new JsonModel($this->service->getList());
    }

    public function saveTreeAction()
    {
        $tree = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
        $this->service->saveTree($tree);
        // todo: report bug to zfcAdmin module
        //return $this->forward('TocatUser\Controller\Admin\Role',array('action' => 'list'));
        return new JsonModel($this->service->getList());
    }
}
