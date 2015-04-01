<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Common\Traits;

/**
 * This trait provides a framework of methods and internal storage which may
 * be useful when using the Decorator pattern to wrap ArrayObject instances.
 *
 * For example if we wanted an ArrayObject which enforces that its values are
 * all of type MyItemInterface, we could:
 *
 *     class MyItemList implements IteratorAggregate, ArrayAccess, Serializable, Countable
 *     {
 *         use ArrayObjectImplementationMethods;
 *
 *         public function __constructor(\ArrayObject $initialObject)
 *         {
 *             $this->setArrayObject($initialObject);
 *         }
 *
 *         // Override offsetSet to enforce the type of $values which can be set
 *         public function offsetSet($offset, MyItemInterface $value)
 *         {
 *             $this->arrayObject->offsetSet($offset, $value);
 *         }
 *     }
 *
 * TODO: handle flags like ArrayObject::ARRAY_AS_PROPS
 */
trait ArrayObjectImplementationMethods
{
    /** @var \ArrayObject $arrayObject */
    private $arrayObject;

    /**
     * Sets the ArrayObject instance which is to be wrapped by the class using
     * this trait.
     *
     * No value is returned.
     *
     * @param \ArrayAccess $arrayObject
     */
    public function setArrayObject(\ArrayAccess $arrayObject)
    {
        $this->arrayObject = $arrayObject;
    }

    /**
     * Gets the ArrayObject instance which is to be wrapped by the class using
     * this trait.
     *
     * @return \ArrayObject The array wrapped by this class.
     */
    public function getArrayObject()
    {
        return $this->arrayObject;
    }

    /* Methods which implement IteratorAggregate */

    /**
     * Implementation of IteratorAggregate::getIterator()
     *
     * Create a new iterator from an ArrayObject instance.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->arrayObject->getIterator();
    }

    /* Methods which implement ArrayAccess */

    /**
     * Implementation of ArrayAccess::offsetExists()
     *
     * Returns whether the requested index exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->arrayObject->offsetExists($offset);
    }

    /**
     * Implementation of ArrayAccess::offsetGet()
     *
     * Returns the value at the specified offset.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->arrayObject->offsetGet($offset);
    }

    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Sets the value at the specified offset.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->arrayObject->offsetSet($offset, $value);
    }

    /**
     * Implementation of ArrayAccess::offsetUnset()
     *
     * Unsets the value at the specified index.
     *
     * No value is returned.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->arrayObject->offsetUnset($offset);
    }

    /* Methods which implement Serializable */

    /**
     * Implementation of ArrayAccess::serialize()
     *
     * Returns a serialized ArrayObject.
     *
     * @return string The serialized representation of the ArrayObject.
     */
    public function serialize()
    {
        return $this->arrayObject->serialize();
    }

    /**
     * Implementation of ArrayAccess::unserialize()
     *
     * Replaces the existing arrayObject with the object referred to by the
     * serialized string.
     *
     * No value is returned.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->arrayObject->unserialize($serialized);
    }

    /* Methods which implement Countable */

    /**
     * Implementation of ArrayAccess::count()
     *
     * Get the number of public properties in the ArrayObject.
     *
     * @return int
     */
    public function count()
    {
        return $this->arrayObject->count();
    }

    /* Other public methods of ArrayObject */

    /**
     * Implementations of ArrayObject::append().
     *
     * Appends a new value as the last element.
     *
     * No value is returned.
     *
     * @param mixed $value The value being appended.
     */
    public function append($value)
    {
        $this->arrayObject->append($value);
    }

    /**
     * Implementation of ArrayObject::asort().
     *
     * Sorts the entries such that the keys maintain their correlation with the
     * entries they are associated with. This is used mainly when sorting
     * associative arrays where the actual element order is significant.
     *
     * No value is returned.
     */
    public function asort()
    {
        $this->arrayObject->asort();
    }

    /**
     * Implementation of ArrayObject::exchangeArray().
     *
     * Exchange the current array with another array or object.
     *
     * @param mixed $input The new array or object to exchange with the current
     *                     array.
     *
     * @return array Returns the old array.
     */
    public function exchangeArray($input)
    {
        return $this->arrayObject->exchangeArray($input);
    }

    /**
     * Implementation of ArrayObject::getArrayCopy().
     *
     * Exports the ArrayObject to an array.
     *
     * @return array Returns a copy of the array. When the ArrayObject refers
     *               to an object an array of the public properties of that
     *               object will be returned.
     */
    public function getArrayCopy()
    {
        return $this->arrayObject->getArrayCopy();
    }

    /**
     * Implementation of ArrayObject::getFlags().
     *
     * Gets the behavior flags of the ArrayObject. See the ArrayObject::setFlags
     * method for a list of the available flags.
     *
     * @return int Returns the behavior flags of the ArrayObject.
     */
    public function getFlags()
    {
        return $this->arrayObject->getFlags();
    }

    /**
     * Implementation of ArrayObject::getIteratorClass().
     *
     * Gets the class name of the array iterator that is used by
     * ArrayObject::getIterator().
     *
     * @return string
     */
    public function getIteratorClass()
    {
        return $this->arrayObject->getIteratorClass();
    }

    /**
     * Implementation of ArrayObject::ksort().
     *
     * Sorts the entries by key, maintaining key to entry correlations. This is
     * useful mainly for associative arrays.
     *
     * No value is returned.
     */
    public function ksort()
    {
        $this->arrayObject->ksort();
    }

    /**
     * Implementation of ArrayObject::natcasesort().
     *
     * This method is a case insensitive version of ArrayObject::natsort.
     *
     * This method implements a sort algorithm that orders alphanumeric strings
     * in the way a human being would while maintaining key/value associations.
     * This is described as a "natural ordering".
     *
     * No value is returned.
     */
    public function natcasesort()
    {
        $this->arrayObject->natcasesort();
    }

    /**
     * Implementation of ArrayObject::natsort().
     *
     * This method implements a sort algorithm that orders alphanumeric strings
     * in the way a human being would while maintaining key/value associations.
     * This is described as a "natural ordering". An example of the difference
     * between this algorithm and the regular computer string sorting algorithms
     * (used in ArrayObject::asort) method can be seen in the example below.
     *
     * No value is returned.
     */
    public function natsort()
    {
        $this->arrayObject->natsort();
    }

    /**
     * Implementation of ArrayObject::setFlags().
     *
     * Set the flags that change the behavior of the ArrayObject.
     *
     * No value is returned.
     *
     * @param int $flags
     */
    public function setFlags($flags)
    {
        $this->arrayObject->setFlags($flags);
    }

    /**
     * Implementation of ArrayObject::setIteratorClass().
     *
     * Sets the classname of the array iterator that is used by ::getIterator().
     *
     * No value is returned.
     *
     * @param string $iteratorClass
     */
    public function setIteratorClass($iteratorClass)
    {
        $this->arrayObject->setIteratorClass($iteratorClass);
    }

    /**
     * Implementation of ArrayObject::uasort().
     *
     * This function sorts the entries such that keys maintain their correlation
     * with the entry that they are associated with, using a user-defined
     * comparison function.
     *
     * This is used mainly when sorting associative arrays where the actual
     * element order is significant.
     *
     * No value is returned.
     *
     * @param callable $cmpFunction The callback comparison function.
     */
    public function uasort($cmpFunction)
    {
        $this->arrayObject->uasort($cmpFunction);
    }

    /**
     * Implementation of ArrayObject::uksort().
     *
     * This function sorts the keys of the entries using a user-supplied
     * comparison function. The key to entry correlations will be maintained.
     *
     * No value is returned.
     *
     * @param callable $cmpFunction The callback comparison function.
     */
    public function uksort($cmpFunction)
    {
        $this->arrayObject->uksort($cmpFunction);
    }
}
