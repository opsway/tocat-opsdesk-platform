<?php
/**
 * @var \OpsWay\AppManager\Service\Manager $this
 */
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

$console = $this->getServiceLocator()->get('console');
/**
 * @var EntityManagerInterface $em
 */
$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
$metadatas = $em->getMetadataFactory()->getAllMetadata();
$schema_tool = new SchemaTool($em);

// update schemas
$schema_tool->updateSchema($metadatas);

$console->writeLine('Database schema was updated.');
