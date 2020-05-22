<?php

namespace Abc\Bundle\SequenceBundle\Doctrine;

use Abc\Bundle\SequenceBundle\Model\SequenceManager as BaseSequenceManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PessimisticLockException;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class SequenceManager extends BaseSequenceManager
{
    /** @var EntityManagerInterface */
    protected $objectManager;
    /** @var string */
    protected $class;
    /** @var ObjectRepository */
    protected $repository;


    /**
     * @param EntityManagerInterface $om
     * @param string                 $class
     */
    public function __construct(EntityManagerInterface $om, $class)
    {
        $this->objectManager = $om;
        $this->repository    = $om->getRepository($class);

        $metadata    = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function getNextValue($name)
    {
        try {
            $this->objectManager->beginTransaction();
            $sequence = $this->findByName($name);
            $this->objectManager->lock($sequence, LockMode::PESSIMISTIC_READ);
            $newValue = $sequence->getCurrentValue() + 1;
            $sequence->setCurrentValue($newValue);
            $this->objectManager->persist($sequence);
            $this->objectManager->flush();
            $this->objectManager->commit();
            return $newValue;
        } catch (PessimisticLockException $e) {
            $this->objectManager->rollback();
            throw $e;
        } catch (\Exception $e) {
            $this->objectManager->rollback();
            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentValue($name)
    {
        $sequence = $this->findByName($name);

        return $sequence->getCurrentValue();
    }

    /**
     * @param string $name
     * @return object
     */
    private function findByName($name)
    {
        $sequence = $this->repository->findOneBy(array('name' => $name));
        if (!$sequence) {
            $sequence = new $this->class;
            $sequence->setName($name);
            $sequence->setCurrentValue(0);
            $this->objectManager->persist($sequence);
            $this->objectManager->flush();
        }
        return $sequence;
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}