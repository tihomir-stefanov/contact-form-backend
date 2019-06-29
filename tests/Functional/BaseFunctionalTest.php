<?php


namespace App\Tests\Integration;


use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class BaseIntegrationTest
 * @package App\Tests\Integration
 */
abstract class BaseFunctionalTest extends WebTestCase
{


}
