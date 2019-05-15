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
 * Class WordStream_Services_Model_Catalog_Product_ApiTest.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_ApiTest extends PHPUnit_Framework_TestCase
{    
    /**
     * @var array
     */
    const TEST_RESULT = array('test' => true);

    /**
     * Tested object.
     *
     * @var mixed
     */
    protected $testedObject;

    /**
     * Get the tested object and set the mock object.
     *
     * @return void
     */
    public function setUp()
    {
       $this->testedObject = Mage::getModel('wordstream_services/catalog_product_api');
       $this->setDataModels();
    }

    /**
     * Testing of the class.
     *
     * @return void
     */
    public function testTestedObjectClass()
    {
        $this->assertInstanceOf(
                WordStream_Services_Model_Catalog_Product_Api::class,
                $this->testedObject
            );
    }

    /**
     * Checking the method.
     *
     * @return void
     */
    public function testCount()
    {
        $responseField = WordStream_Services_Model_Catalog_Product_DataForTesting::COUNT_RESPONSE_FIELD;

        $this->assertEquals(
                $this->testedObject
                    ->count(
                        WordStream_Services_Model_Catalog_Product_DataForTesting::FILTERS,
                        WordStream_Services_Model_Catalog_Product_DataForTesting::QUANTITY_FILTER_AMOUNT,
                        WordStream_Services_Model_Catalog_Product_DataForTesting::getDefaultStoreId(),
                        $responseField
                    ),
                array($responseField => WordStream_Services_Model_Catalog_Product_DataForTesting::COUNT_TEST_RESULT)
            );
    }

    /**
     * Checking the method.
     *
     * @return void
     */
    public function testExtendedList()
    {
        $this->assertEquals(
            $this->testedObject
                ->extendedList(
                    WordStream_Services_Model_Catalog_Product_DataForTesting::FILTERS,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::QUANTITY_FILTER_AMOUNT,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::getDefaultStoreId(),
                    WordStream_Services_Model_Catalog_Product_DataForTesting::STANDARD_ATTRIBUTES,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::CUSTOM_ATTRIBUTES,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::QTY_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::IS_IN_STOCK_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::ATTR_SET_NAME_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::CATEGORY_BREADCRAMBS_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::MANUFACTURER_NAME_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::ABS_URL_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::ABS_IMAGE_URL_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::SCRUB_PRODUCT_NAME,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::SCRUB_DESCRIPTION,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::SCRUB_SHORT_DESCRIPTION,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::SCRUB_ATTR_SET_NAME,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::SCRUB_CUSTOM_ATTR,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::PAGE_NUMBER,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::PRODUCT_PER_PAGE,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::PARENT_SKU_CONFIG,
                    WordStream_Services_Model_Catalog_Product_DataForTesting::ADDITIONAL_IMAGES_CONFIG
                ),
            self::TEST_RESULT
        );
    }

    /**
     * Set stubs to the tested object.
     *
     * @return void
     */
    private function setDataModels()
    {
        $propCount = new ReflectionProperty('WordStream_Services_Model_Catalog_Product_Api', '_countModel');
        $propCount->setAccessible(true);
        $propCount->setValue($this->testedObject, $this->getCountStubModel());

        $propExtendedList = new ReflectionProperty('WordStream_Services_Model_Catalog_Product_Api', '_extendedListModel');
        $propExtendedList->setAccessible(true);
        $propExtendedList->setValue($this->testedObject, $this->getExtendedListStubModel());
    }

    /**
     * Creating the stub object.
     *
     * @return PHPUnit\Framework\MockObject\MockObject
     */
    private function getCountStubModel()
    {
        $stub = $this->createMock(WordStream_Services_Model_Catalog_Product_Count::class);
        $stub->method('count')
             ->willReturn(WordStream_Services_Model_Catalog_Product_DataForTesting::COUNT_TEST_RESULT);

        return $stub;
    }

    /**
     * Creating the stub object.
     *
     * @return PHPUnit\Framework\MockObject\MockObject
     */
    private function getExtendedListStubModel()
    {
        $stub = $this->createMock(WordStream_Services_Model_Catalog_Product_ExtendedList::class);
        $stub->method('extendedList')
             ->willReturn(self::TEST_RESULT);

        return $stub;
    }
}
