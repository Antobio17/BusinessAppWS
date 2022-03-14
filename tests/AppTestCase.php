<?php

namespace App\Tests;

use App\Entity\Interfaces\ORMInterface;
use App\Helper\ToolsHelper;
use App\Service\Traits\RepositoriesTrait;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AppTestCase extends WebTestCase
{

    /************************************************* PROPERTIES *************************************************/

    /**
     * @var EntityManager
     */
    private $entityManager;

    use RepositoriesTrait;

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * @inheritDoc
     * @return EntityManager EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * Sets Up the EntityManager to manage the database.
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @inheritDoc
     * @return bool bool
     */
    public function persistAndFlush(ORMInterface $object): bool
    {
            try {
                $entityManager = $this->getEntityManager();
                $entityManager->persist($object);
                $entityManager->flush();
                $persisted = TRUE;
            } catch (Exception $e) {
                $persisted = FALSE;
            }

        return $persisted;
    }

    /**
     * Tears down the EntityManager to manage the database.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        # To avoid memory leaks
        $this->getEntityManager()->close();
        $this->entityManager = null;
    }

}