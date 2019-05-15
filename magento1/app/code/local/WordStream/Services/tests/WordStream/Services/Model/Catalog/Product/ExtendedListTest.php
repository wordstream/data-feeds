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
 * Class WordStream_Services_Model_Catalog_Product_ExtendedListTest.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_ExtendedListTest
    extends WordStream_Services_Model_Catalog_Product_AbstractBaseProductsData
{
    /**
     * Testing data.
     *
     * @var mixed
     */
    const STOCK_QTY = 7;
    const IS_IN_STOCK = 1;
    const SOURCE_ATTR_SET_NAME = 'Default\r\nattribute\rset';
    const SCRUBBING_ATTR_SET_NAME = 'Default  attribute set';
    const CONFIGURABLE_PARENT_IDS = array(1, 2, 3);
    const GROUPED_PARENT_IDS = array(11 , 12, 13);
    const TEST_URL_PATH = 'test_url_path';
    const TEST_PARENT_IMAGE = '/parent_image';
    const TEST_PARENT_SKU = 'parent_sku';
    const TEST_SMALL_IMAGE = 'small_image';
    const TEST_THUMBNAIL = 'thumbnail';

    /**
     * Get the tested object and set the mock objects.
     *
     * @return void
     */
    public function setUp()
    {
       parent::setUp();

       $this->setStockItemModelStub();
       $this->setAttributeSetModelStub();
       $this->setCategoryModelStub();
       $this->setConfigurableTypeModelStub();
       $this->setGroupedTypeModelStub();
       $this->setProductModelStub();
    }

    /**
     * Set tested object.
     *
     * @return void
     */
    protected function setTestedObject()
    {
        $this->testedObject = Mage::getModel('wordstream_services/catalog_product_extendedList');
    }

    /**
     * Creating the stub object.
     *
     * @return PHPUnit\Framework\MockObject\MockObject
     */
    protected function getCollectionStub()
    {
        $stub = $this->getMockBuilder(
                get_class(Mage::getModel('catalog/product')->getCollection())
            )
            ->setMethods(array('getItems'))
            ->getMock();

        $stub->method('getItems')
             ->willReturn(WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems());

        return $stub;
    }

    /**
     * Set stub to the tested object.
     *
     * @return void
     */
    protected function setStockItemModelStub()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_stockItemModel');
        $prop->setAccessible(true);

        $stub = $this->getMockBuilder(
                get_class(Mage::getModel('cataloginventory/stock_item'))
            )->setMethods(array('loadByProduct', 'clearInstance'))
            ->getMock();

        $dataObj = new Varien_Object();
        $dataObj->setQty(self::STOCK_QTY);
        $dataObj->setIsInStock(self::IS_IN_STOCK);

        $stub->method('loadByProduct')
             ->willReturn($dataObj);

        $prop->setValue($this->testedObject, $stub);
    }

    /**
     * Set stub to the tested object.
     *
     * @return void
     */
    protected function setAttributeSetModelStub()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_attributeSetModel');
        $prop->setAccessible(true);

        $stub = $this->getMockBuilder(
                get_class(Mage::getModel('eav/entity_attribute_set'))
            )->setMethods(array('load', 'clearInstance'))
            ->getMock();

        $dataObj = new Varien_Object();
        $dataObj->setId(1);
        $dataObj->setAttributeSetName(self::SOURCE_ATTR_SET_NAME);

        $stub->method('load')
             ->willReturn($dataObj);

        $prop->setValue($this->testedObject, $stub);
    }

    /**
     * Set stub to the tested object.
     *
     * @return void
     */
    protected function setCategoryModelStub()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_categoryModel');
        $prop->setAccessible(true);

        $stub = $this->getMockBuilder(
                get_class(Mage::getModel('catalog/category'))
            )->setMethods(array('load', 'clearInstance'))
            ->getMock();

        $dataObj = new Varien_Object();
        $dataObj->setId(1);
        $dataObj->setName('Category');

        $stub->method('load')
             ->willReturn($dataObj);

        $prop->setValue($this->testedObject, $stub);
    }

    /**
     * Set stub to the tested object.
     *
     * @return void
     */
    protected function setConfigurableTypeModelStub()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_configurableTypeModel');
        $prop->setAccessible(true);

        $stub = new Varien_Object();
        $stub->setParentIdsByChild(self::CONFIGURABLE_PARENT_IDS);

        $prop->setValue($this->testedObject, $stub);
    }

    /**
     * Set stub to the tested object.
     *
     * @return void
     */
    protected function setGroupedTypeModelStub()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_groupedTypeModel');
        $prop->setAccessible(true);

        $stub = new Varien_Object();
        $stub->setParentIdsByChild(self::GROUPED_PARENT_IDS);

        $prop->setValue($this->testedObject, $stub);
    }

    /**
     * Set stub to the tested object.
     *
     * @return void
     */
    protected function setProductModelStub()
    {
        $prop = new ReflectionProperty(get_class($this->testedObject), '_productModel');
        $prop->setAccessible(true);

        $stub = $this->getMockBuilder(
                get_class(Mage::getModel('catalog/product'))
            )->setMethods(array('load', 'clearInstance'))
            ->getMock();

        $dataObj = new Varien_Object();
        $dataObj->setUrlPath(self::TEST_URL_PATH);
        $dataObj->setImage(self::TEST_PARENT_IMAGE);
        $dataObj->setSku(self::TEST_PARENT_SKU);
        $dataObj->setMediaGalleryImages(
                array(
                    array(
                        'url' => self::TEST_SMALL_IMAGE
                    ),
                    array(
                        'url' => self::TEST_THUMBNAIL
                    )
                )
            );

        $stub->method('load')
             ->willReturn($dataObj);

        $prop->setValue($this->testedObject, $stub);
    }

    /**
     * Testing of the class.
     *
     * @return void
     */
    public function testTestedObjectClass()
    {
        $this->assertInstanceOf(
                WordStream_Services_Model_Catalog_Product_ExtendedList::class,
                $this->testedObject
            );
    }

    /**
     * Checking the method.
     *
     * @return void
     */
    public function testExtendedList()
    {
        $result = $this->testedObject->extendedList(
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
            );

        $this->checkResult($result);
        $this->checkCollection();
    }

    /**
     * Test the collection.
     *
     * @return void
     */
    protected function checkCollection()
    {
        $collection = $this->testedObject->getProductCollection();

        $this->checkCollectionClass($collection);
        $this->checkCollectionStoreFilter($collection);
        $this->checkQtyFilter($collection);
        $this->checkFilters($collection);
        $this->checkCollectionAttirbutes($collection);
    }

    /**
     * Test the collection,
     * checking if all filters and selected attributes were added to the request.
     *
     * @return void
     */
    protected function checkCollectionAttirbutes($collection)
    {
        $ref = new ReflectionClass(get_class($collection));
        $refProp = $ref->getProperty('_selectAttributes');
        $refProp->setAccessible(true);
        $attributes = $refProp->getValue($collection);

        foreach (WordStream_Services_Model_Catalog_Product_DataForTesting::FILTERS as $attr => $val) {
            $this->assertArrayHasKey($attr, $attributes);
        }

        foreach (WordStream_Services_Model_Catalog_Product_DataForTesting::STANDARD_ATTRIBUTES as $attr) {
            $this->assertArrayHasKey($attr, $attributes);
        }

        foreach (WordStream_Services_Model_Catalog_Product_DataForTesting::CUSTOM_ATTRIBUTES as $attr) {
            $this->assertArrayHasKey($attr, $attributes);
        }
    }

    /**
     * Test the result.
     *
     * @param array $result
     * @return void
     */
    protected function checkResult($result)
    {
        $this->checkStandardAttributesAndScrubbing($result);
        $this->checkCustomAttributesAndScrubbing($result);
        $this->checkStockData($result);
        $this->checkAttrSetData($result);
        $this->checkCategoryData($result);
        $this->checkManufacturerData($result);
        $this->checkUrlAndImage($result);
        $this->checkAdditionalImage($result);
    }

    /**
     * Checking standard attributes + scrubbing of them,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     *
     * @param array $result
     * @return void
     */
    protected function checkStandardAttributesAndScrubbing($result)
    {
        $this->assertEquals('First', $result[0]['name']);
        $this->assertEquals('First description', $result[0]['description']);
        $this->assertEquals('First    short_description', $result[0]['short_description']);
    }

    /**
     * Checking custom attributes + scrubbing of them,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     *
     * @param array $result
     * @return void
     */
    protected function checkCustomAttributesAndScrubbing($result)
    {
        $this->assertEquals('First bed_bath_type', $result[0]['bed_bath_type']);
        $this->assertEquals('First', $result[0]['camera_megapixels']);
    }

    /**
     * Checking stock data.
     *
     * @param array $result
     * @return void
     */
    protected function checkStockData($result)
    {
        $this->assertEquals(
                self::STOCK_QTY,
                $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::QTY_CONFIG[1]]
            );
        $this->assertEquals(
                self::IS_IN_STOCK,
                $result[1][WordStream_Services_Model_Catalog_Product_DataForTesting::IS_IN_STOCK_CONFIG[1]]
            );
    }

    /**
     * Checking attribute set data,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     *
     * @param array $result
     * @return void
     */
    protected function checkAttrSetData($result)
    {
        $this->assertEquals(
            self::SCRUBBING_ATTR_SET_NAME,
            $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::ATTR_SET_NAME_CONFIG[1]]
        );
    }

    /**
     * Checking category data data,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     *
     * @param array $result
     * @return void
     */
    protected function checkCategoryData($result)
    {
        $this->assertEquals(
            'Category > Category > Category > Category',
            $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::CATEGORY_BREADCRAMBS_CONFIG[1]]
        );
    }

    /**
     * Checking manufacturer data,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     *
     * @param array $result
     * @return void
     */
    protected function checkManufacturerData($result)
    {
        $this->assertEquals(
            '',
            $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::MANUFACTURER_NAME_CONFIG[1]]
        );
    }

    /**
     * Checking URL and image data,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     * This test checks different ways of preparing data
     * in WordStream_Services_Model_Catalog_Product_ExtendedList::getUrlAndImage().
     *
     * @param array $result
     * @return void
     */
    protected function checkUrlAndImage($result)
    {
        $store = Mage::getModel('core/store')->load(
                WordStream_Services_Model_Catalog_Product_DataForTesting::getDefaultStoreId()
            );
        $baseUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $imageBaseURL = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product';

        // The first test product has type=virtual so its URL was built from the value of its attribute 'url_path'.
        $this->assertEquals(
                $baseUrl . 'url_path',
                $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::ABS_URL_CONFIG[1]]
            );

        // List of parent SKUs was prepared according to the request parameters.
        $this->assertEquals(
                array(self::TEST_PARENT_SKU, self::TEST_PARENT_SKU, self::TEST_PARENT_SKU),
                $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::PARENT_SKU_CONFIG[1]]
            );

        // The second and the third products are "simple",
        // some of their data were built with data their parent products.
        $this->assertEquals(
                $baseUrl . self::TEST_URL_PATH,
                $result[1][WordStream_Services_Model_Catalog_Product_DataForTesting::ABS_URL_CONFIG[1]]
            );
        $this->assertEquals(
                $imageBaseURL . '/image',
                $result[1][WordStream_Services_Model_Catalog_Product_DataForTesting::ABS_IMAGE_URL_CONFIG[1]]
            );
        $this->assertEquals(
                $imageBaseURL . self::TEST_PARENT_IMAGE,
                $result[2][WordStream_Services_Model_Catalog_Product_DataForTesting::ABS_IMAGE_URL_CONFIG[1]]
            );
    }

    /**
     * Checking additional image data,
     * source data you can see WordStream_Services_Model_Catalog_Product_DataForTesting::getTestItems().
     *
     * @param array $result
     * @return void
     */
    protected function checkAdditionalImage($result)
    {
        $this->assertEquals(
                array(self::TEST_SMALL_IMAGE, self::TEST_THUMBNAIL),
                $result[0][WordStream_Services_Model_Catalog_Product_DataForTesting::ADDITIONAL_IMAGES_CONFIG[1]]
            );
    }
}
