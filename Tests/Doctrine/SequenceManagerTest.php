<?php
namespace Abc\Bundle\SequenceBundle\Tests\Doctrine;

use Abc\Bundle\SequenceBundle\Doctrine\SequenceManager;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class SequenceManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class;
    /** @var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject */
    private $classMetaData;
    /** @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject */
    private $objectManager;
    /** @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $repository;

    /** @var SequenceManager */
    private $subject;

    public function setUp()
    {
        $this->class         = 'Abc\Bundle\SequenceBundle\Entity\Sequence';
        $this->classMetaData = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository    = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($this->classMetaData));

        $this->classMetaData->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($this->class));

        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->repository));

        $this->subject = new SequenceManager($this->objectManager, $this->class);
    }

    public function testGetClass()
    {
        $this->assertEquals($this->class, $this->subject->getClass());
    }

    public function testGetCurrentValueWithNotExistingSequenceReturnsZero()
    {
        $sequenceName = 'ABC';
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with(array('name' => $sequenceName))
            ->willReturn(null);

        $this->objectManager->expects($this->once())
            ->method('persist');
        $this->objectManager->expects($this->once())
            ->method('flush');

        $result = $this->subject->getCurrentValue($sequenceName);

        $this->assertEquals(0, $result);
    }

    public function testGetCurrentValueWithExistingSequenceReturnsCurrentValue()
    {
        $currentValue = 2;
        $sequenceName = 'ABC';
        $sequence     = new $this->class;
        $sequence->setCurrentValue($currentValue);
        $sequence->setName($sequenceName);

        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with(array('name' => $sequenceName))
            ->willReturn($sequence);

        $this->objectManager->expects($this->never())
            ->method('persist');
        $this->objectManager->expects($this->never())
            ->method('flush');

        $result = $this->subject->getCurrentValue($sequenceName);

        $this->assertEquals($currentValue, $result);
    }

    public function testGetNextValueWithExistingSequenceReturnsNextValue()
    {
        $currentValue = 2;
        $sequenceName = 'ABC';
        $sequence     = new $this->class;
        $sequence->setCurrentValue($currentValue);
        $sequence->setName($sequenceName);

        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with(array('name' => $sequenceName))
            ->willReturn($sequence);

        $this->objectManager->expects($this->once())
            ->method('persist');
        $this->objectManager->expects($this->once())
            ->method('flush');

        $result = $this->subject->getNextValue($sequenceName);

        $this->assertEquals($currentValue + 1, $result);
    }

    public function testGetNextValueWithNotExistingSequenceReturnsNextValue()
    {
        $sequenceName = 'ABC';
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with(array('name' => $sequenceName))
            ->willReturn(null);

        $this->objectManager->expects($this->any())
            ->method('persist');
        $this->objectManager->expects($this->any())
            ->method('flush');

        $result = $this->subject->getNextValue($sequenceName);

        $this->assertEquals(1, $result);
    }
}
 