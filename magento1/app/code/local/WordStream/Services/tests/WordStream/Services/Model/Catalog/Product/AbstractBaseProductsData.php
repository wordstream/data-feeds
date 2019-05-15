<?php
/**
 * Copyright 2019 WordStream, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

/**
 * Class WordStream_Services_Model_Catalog_Product_AbstractBaseProductsData.
 * @package WordStream_Services
 * @author  yvechirko
 */
abstract class WordStream_Services_Model_Catalog_Product_AbstractBaseProductsData extends PHPUnit_Framework_TestCase
{
    /**
     * Tested object.
     *
     * @return void
     */
    protected $testedObject;

    /**
     * Get the tested object and set the mock object.
     * @throws ReflectionException
     * @return void
     */
    public function setUp()
    {
        $this->setTestedObject();
        $this->setStubCollection();
    }

    /**
     * Set tested object.
     *
     * @return void
     */
    abstract protected function setTestedObject();

    /**
     * Set stubs to the tested object.
     * @throws ReflectionException
     * @return void
     */
    protected function setStubCollection()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_productCollection');
        $prop->setAccessible(true);
        $prop->setValue($this->testedObject, $this->getCollectionStub());
    }

    /**
     * Creating the stub object.
     *
     * @return PHPUnit\Framework\MockObject\MockObject
     */
    abstract protected function getCollectionStub();

    /**
     * Test the class of the collection object.
     *
     * @param Mage_Catalog_Model_Resource_Product_Collection $collection
     *
     * @return void
     */
    protected function checkCollectionClass($collection)
    {
        $this->assertInstanceOf(
            Mage_Catalog_Model_Resource_Product_Collection::class,
            $collection
        );
    }

    /**
     * Test the store filter of the collection.
     *
     * @param Mage_Catalog_Model_Resource_Product_Collection $collection
     *
     * @return void
     */
    protected function checkCollectionStoreFilter($collection)
    {
        $filters = $collection->getLimitationFilters();
        $this->assertArrayHasKey('store_id', $filters);
        $this->assertContains(
            WordStream_Services_Model_Catalog_Product_DataForTesting::getDefaultStoreId(),
            $filters
        );
    }

    /**
     * Test the filter by qty
     * checking if was added the qty query to the collection select.
     *
     * @param Mage_Catalog_Model_Resource_Product_Collection $collection
     *
     * @return void
     */
    protected function checkQtyFilter($collection)
    {
        $queryString = $collection->getSelect()->__toString();

        $this->assertNotEquals(
            false,
            stripos(
                $queryString,
                'qty >= ' . WordStream_Services_Model_Catalog_Product_DataForTesting::QUANTITY_FILTER_AMOUNT
            )
        );
    }

    /**
     * Test the filters of collection
     * checking if was added the attribute of filtering to the collection select.
     *
     * @param Mage_Catalog_Model_Resource_Product_Collection $collection
     *
     * @return void
     */
    protected function checkFilters($collection)
    {
        $queryString = $collection->getSelect()->__toString();
        $attr = key(WordStream_Services_Model_Catalog_Product_DataForTesting::FILTERS);
        $val = WordStream_Services_Model_Catalog_Product_DataForTesting::FILTERS[$attr]['eq'];

        $this->assertEquals(1, preg_match("/$attr\.value(.*)= $val/i", $queryString));
    }
}
