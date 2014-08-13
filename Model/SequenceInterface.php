<?php

namespace Abc\Bundle\SequenceBundle\Model;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
interface SequenceInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return integer
     */
    public function getCurrentValue();

    /**
     * @param integer $currentValue
     */
    public function setCurrentValue($currentValue);
} 