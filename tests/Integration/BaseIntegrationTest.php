<?php


namespace App\Tests\Integration;


use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BaseIntegrationTest
 * @package App\Tests\Integration
 */
abstract class BaseIntegrationTest extends KernelTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected static $em;

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::generateDatabase();
    }

    /**
     *
     */
    protected function setUp()
    {
        self::bootKernel();
        static::$em = static::getEntityManager();
        $this->truncateEntities();
    }

    /**
     * @return EntityManagerInterface
     */
    protected static function getEntityManager(): EntityManagerInterface
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        // gets the special container that allows fetching private services
        return self::$container;
    }

    /**
     *
     */
    protected function truncateEntities(): void
    {
        $purger = new ORMPurger(static::$em);
        $purger->purge();
    }

    /**
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    private static function generateDatabase()
    {
        self::bootKernel();

        $em = static::getEntityManager();
        $schemaTool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        // Drop and recreate tables for all entities
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }


}
