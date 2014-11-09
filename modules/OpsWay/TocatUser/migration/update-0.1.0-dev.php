<?php
/**
 * @var \OpsWay\AppManager\Service\Manager $this
 */
use Doctrine\ORM\EntityManagerInterface;
use OpsWay\TocatUser\Service\PermissionService;
use Zend\Crypt\Password\Bcrypt;

$console = $this->getServiceLocator()->get('console');
$console = $this->getServiceLocator()->get('console');
/**
 * @var EntityManagerInterface $em
 */
$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

$roleG = new \OpsWay\TocatUser\Entity\Role();
$roleG->setRoleId('guest');

$roleU = new \OpsWay\TocatUser\Entity\Role();
$roleU->setParent($roleG);
$roleU->setRoleId('user');

$roleA = new \OpsWay\TocatUser\Entity\Role();
$roleA->setParent($roleU);
$roleA->setRoleId('admin');

$user = new \OpsWay\TocatUser\Entity\User();
$user->setDisplayName('Admin Adminych');
$user->setEmail('admin@test.com');
$user->setState(1);
$user->setUsername('admin');
$bcrypt = new Bcrypt();
$bcrypt->setCost(14);
$user->setPassword($bcrypt->create('admin123'));
$user->addRole($roleA);

$em->persist($roleG);
$em->persist($roleU);
$em->persist($roleA);
$em->persist($user);
/**
 * @var PermissionService $permissionService
 */
$permissionService = $this->getServiceLocator()->get(PermissionService::class);
foreach ($permissionService->getAllStaticControllerGuard() as $controller => $action) {
    $aclEntity = new \OpsWay\TocatUser\Entity\Permission();
    $aclEntity->setRole($roleA);
    $aclEntity->setResource($controller);
    $aclEntity->setType('guard');
    $em->persist($aclEntity);
}

$aclEntity2 = new \OpsWay\TocatUser\Entity\Permission();
$aclEntity2->setRole($roleU);
$aclEntity2->setResource('zfcuser');
$aclEntity2->setType('guard');
$em->persist($aclEntity2);

$aclEntity3 = new \OpsWay\TocatUser\Entity\Permission();
$aclEntity3->setRole($roleU);
$aclEntity3->setResource('OpsWay\TocatCore\Controller\Index');
$aclEntity3->setType('guard');
$em->persist($aclEntity3);

$aclEntity4 = new \OpsWay\TocatUser\Entity\Permission();
$aclEntity4->setRole($roleG);
$aclEntity4->setResource('ZfcUserOnelogin\OneloginController');
$aclEntity4->setType('guard');
$em->persist($aclEntity4);

$aclEntity5 = new \OpsWay\TocatUser\Entity\Permission();
$aclEntity5->setRole($roleG);
$aclEntity5->setResource('zfcuser');
$aclEntity5->setPrivileges('login,authenticate,register,notFound');
$aclEntity5->setType('guard');
$em->persist($aclEntity5);

$em->flush();

$console->writeLine('Default Users & Roles & Permissions was created.');
