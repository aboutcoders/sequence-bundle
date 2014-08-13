<?php

namespace Abc\Bundle\SequenceBundle\Model;

/**
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
interface SequenceManagerInterface
{

    /**
     * Returns current value of sequence
     *
     * @param string $name Name of sequence
     * @return integer
     */
    public function getCurrentValue($name);

    /**
     * Returns next value of sequence
     *
     * @param string $name Name of sequence
     * @return integer
     */
    public function getNextValue($name);

    /**
     * Returns the Sequence's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}