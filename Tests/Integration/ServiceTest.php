<?php

namespace Abc\Bundle\SequenceBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceTest extends KernelTestCase
{

    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();

        $this->container = static::$kernel->getContainer();

        $application = new Application(static::$kernel);
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);
    }

    public function testSequenceManager()
    {
        $subject = $this->container->get('abc.sequence.sequence_manager');

        $this->assertInstanceOf('Abc\Bundle\SequenceBundle\Model\SequenceManagerInterface', $subject);
    }

}