<?php

/*
 * This file is part of the Acquia Platform: Cloud Data Model.
 *
 * (c) Acquia, Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acquia\Platform\Cloud\Tests\Common\Traits;

/**
 * @coversDefaultClass Acquia\Platform\Cloud\Common\Traits\ArrayObjectImplementationMethods
 */
class ArrayObjectImplementationMethodsTest extends \PHPUnit_Framework_TestCase
{
    const TEST_TRAIT = 'Acquia\Platform\Cloud\Common\Traits\ArrayObjectImplementationMethods';
    const TEST_ITERATOR = 'Acquia\Platform\Cloud\Tests\Fixtures\MockArrayIterator';

    /**
     * Returns a Mock based on the ArrayObjectImplementationMethods trait.
     *
     * @param \ArrayObject $seedArray
     *
     * @return \ArrayObject
     */
    protected function getArrayObjectDecorator(\ArrayObject $seedArray)
    {
        $mock = $this->getMockForTrait(self::TEST_TRAIT);
        $mock->setArrayObject($seedArray);
        return $mock;
    }

    /**
     * @covers ::setArrayObject
     * @covers ::getArrayObject
     */
    public function testArrayObjectPropertyMayBeSetAndGet()
    {
        $arrayObject = new \ArrayObject(['a', 'b', 'c']);
        $mock = $this->getArrayObjectDecorator($arrayObject);
        $this->assertEquals($arrayObject, $mock->getArrayObject());

        $arrayObject = new \ArrayObject(['a' => 1, 'b' => 2, 'c' => 3]);
        $mock = $this->getArrayObjectDecorator($arrayObject);
        $this->assertEquals($arrayObject, $mock->getArrayObject());
    }

    /**
     * @covers ::getIterator
     * @dataProvider basicDataProvider()
     */
    public function testTraitImpartsIteratorAggregate(\ArrayObject $seedArray)
    {
        $mock = $this->getArrayObjectDecorator($seedArray);
        $this->assertInstanceOf('\ArrayIterator', $mock->getIterator());
    }

    /**
     * @covers ::offsetExists
     * @covers ::offsetGet
     * @covers ::offsetSet
     * @covers ::offsetUnset
     * @dataProvider basicDataProvider()
     */
    public function testTraitImpartsArrayAccess(\ArrayObject $seedArray)
    {
        $mock = $this->getArrayObjectDecorator($seedArray);
        $this->assertEquals($seedArray->offsetExists(0), $mock->offsetExists(0));
        $this->assertEquals($seedArray->offsetExists(1), $mock->offsetExists(1));
        $this->assertEquals($seedArray->offsetExists('a'), $mock->offsetExists('a'));

        if ($mock->offsetExists('a')) {
            $this->assertEquals(1, $mock->offsetGet('a'));
        }
        if ($mock->offsetExists('b')) {
            $this->assertEquals(2, $mock->offsetGet('b'));
        }

        $time = time();
        $mock->offsetSet(__FUNCTION__, $time);
        $this->assertTrue($mock->offsetExists(__FUNCTION__));
        $this->assertEquals($time, $mock->offsetGet(__FUNCTION__));
        $mock->offsetUnset(__FUNCTION__);
        $this->assertFalse($mock->offsetExists(__FUNCTION__));
    }

    /**
     * @covers ::serialize
     * @covers ::unserialize
     * @dataProvider basicDataProvider()
     */
    public function testTraitImpartsSerializableInterface(\ArrayObject $seedArray)
    {
        $serialString = $seedArray->serialize();
        $mock = $this->getArrayObjectDecorator($seedArray);
        $this->assertEquals($serialString, $mock->serialize());

        $mock2 = $this->getArrayObjectDecorator(new \ArrayObject());
        $mock2->unserialize($serialString);
        $this->assertEquals($serialString, $mock2->serialize());
    }

    /**
     * @covers ::count
     * @dataProvider basicDataProvider()
     */
    public function testTraitImpartsCountableInterface(\ArrayObject $seedArray)
    {
        $count = $seedArray->count();
        $mock = $this->getArrayObjectDecorator($seedArray);
        $this->assertEquals($count, $mock->count());
    }

    /**
     * @covers ::append
     * @covers ::getArrayCopy
     * @covers ::getIteratorClass
     * @covers ::setIteratorClass
     * @dataProvider basicDataProvider()
     */
    public function testTraitImpartsArrayObjectPublicMethods(\ArrayObject $seedArray)
    {
        // append
        $count = $seedArray->count();
        $mock = $this->getArrayObjectDecorator($seedArray);
        $mock->append('x');
        $this->assertEquals($count+1, $mock->count());

        // setIteratorClass
        $mock->setIteratorClass(self::TEST_ITERATOR);
        $this->assertInstanceOf(self::TEST_ITERATOR, $mock->getIterator());
        $this->assertEquals(self::TEST_ITERATOR, $mock->getIteratorClass());

        // getArrayCopy
        $this->assertEquals('array', gettype($mock->getArrayCopy()));
    }

    public function basicDataProvider()
    {
        return [
            '0' => [new \ArrayObject()],
            '1' => [new \ArrayObject([1])],
            '1a' => [new \ArrayObject(['a' => 1])],
            '2' => [new \ArrayObject([1, 2])],
            '2a' => [new \ArrayObject(['a' => 1, 'b' => 2])],
        ];
    }
}
