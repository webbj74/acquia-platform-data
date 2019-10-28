<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Hosting\Environment;

use Acquia\Platform\Cloud\Hosting\EnvironmentInterface;
use ArrayObject;
use InvalidArgumentException;

class EnvironmentList extends ArrayObject implements EnvironmentListInterface
{
    /**
     * Implementation of ArrayAccess::offsetGet()
     *
     * Overrides ArrayObject::offsetGet() to allow using an Environment name as
     * a key.
     *
     * @param mixed $index
     *
     * @return mixed|null
     */
    public function offsetGet($index)
    {
        if (is_numeric($index)) {
            return parent::offsetGet($index);
        }
        if (strpos($index, '.') > 0) {
            return $this->getEnvironmentByApplicationQualifiedName($index);
        }
        return $this->getEnvironmentByMachineName($index);
    }
    
    /**
     * Implementation of ArrayAccess::offsetSet()
     *
     * Overrides ArrayObject::offsetSet() to validate that the value set at the
     * specified offset is an Environment.
     *
     * No value is returned.
     *
     * @param mixed $offset
     * @param \Acquia\Platform\Cloud\Hosting\EnvironmentInterface $value
     */
    public function offsetSet($offset, $value)
    {
        if (!is_subclass_of($value, 'Acquia\Platform\Cloud\Hosting\EnvironmentInterface')) {
            throw new InvalidArgumentException(
                sprintf('%s: $value must be an implementation of EnvironmentInterface', __METHOD__)
            );
        }
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function filterByName($names)
    {
        if (is_string($names)) {
            $names = explode(',', $names);
        }

        if (!is_array($names)) {
            throw new InvalidArgumentException(
                sprintf('%s: $names must be an array (or comma-delimited string)', __METHOD__)
            );
        }

        $filteredList = new static();
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            if (in_array($iterator->current()->getName(), $names)) {
                $filteredList->append($iterator->current());
            }
            $iterator->next();
        }

        return $filteredList;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentByMachineName($name)
    {
        $namedEnvironment = null;
        foreach ($this as $environment) {
            if ($environment->getMachineName() === $name) {
                $namedEnvironment = $environment;
            }
        }
        return $namedEnvironment;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentByApplicationQualifiedName($name)
    {
        $namedEnvironment = null;
        /** @var EnvironmentInterface $environment */
        foreach ($this as $environment) {
            if ($environment->getApplicationQualifiedName() === $name) {
                $namedEnvironment = $environment;
            }
        }
        return $namedEnvironment;
    }

    /**
     * {@inheritdoc}
     */
    public function getNames()
    {
        $names = [];
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            $names[$iterator->current()->getName()] = $iterator->current()->getMachineName();
            $iterator->next();
        }
        return $names;
    }
}
