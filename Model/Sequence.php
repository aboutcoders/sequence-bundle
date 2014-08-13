<?php

namespace Abc\Bundle\SequenceBundle\Model;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class Sequence implements SequenceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $currentValue;

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentValue($currentValue)
    {
        $this->currentValue = $currentValue;
    }
} 