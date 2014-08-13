<?php

namespace Abc\Bundle\SequenceBundle\Entity;

use Abc\Bundle\SequenceBundle\Doctrine\SequenceManager as BaseSequenceManager;
use Doctrine\ORM\EntityManager;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class SequenceManager extends BaseSequenceManager
{
    /** @var EntityManager */
    protected $em;


    /**
     * @param EntityManager $em
     * @param string        $class
     */
    public function __construct(EntityManager $em, $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }
}