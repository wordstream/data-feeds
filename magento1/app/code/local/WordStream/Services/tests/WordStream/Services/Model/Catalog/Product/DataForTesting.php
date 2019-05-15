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
 * Class WordStream_Services_Model_Catalog_Product_DataForTesting.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_DataForTesting
{
    /**
     * Data for testing.
     */
    const COUNT_RESPONSE_FIELD = 'product_count';
    const COUNT_TEST_RESULT = 43;
    const FILTERS = array('visibility' => array('eq' => 4));
    const QUANTITY_FILTER_AMOUNT = 0;
    const STANDARD_ATTRIBUTES = array(
            'sku',
            'name',
            'description',
            'short_description',
            'price',
            'special_price',
            'weight',
            'type_id',
            'qty',
            'is_in_stock',
            'attribute_set_name',
            'visibility_name',
            'category_breadcrumb',
            'manufacturer_name',
            'absolute_url',
            'absolute_image_url',
            'ParentSku',
            'use_config_backorders',
            'isSaleable',
            'visibility',
        );
    const CUSTOM_ATTRIBUTES = array('bed_bath_type', 'camera_megapixels');
    const QTY_CONFIG = array(1, 'qty');
    const IS_IN_STOCK_CONFIG = array(1, 'is_in_stock');
    const ATTR_SET_NAME_CONFIG = array(1, 'attribute_set_name');
    const CATEGORY_BREADCRAMBS_CONFIG = array(1, 'category_breadcrumb');
    const MANUFACTURER_NAME_CONFIG = array(1, 'manufacturer_name', 'No');
    const ABS_URL_CONFIG = array(1, 'absolute_url');
    const ABS_IMAGE_URL_CONFIG = array(1, 'absolute_image_url', 'no_selection');
    const SCRUB_PRODUCT_NAME = 1;
    const SCRUB_DESCRIPTION = 1;
    const SCRUB_SHORT_DESCRIPTION = 1;
    const SCRUB_ATTR_SET_NAME = 1;
    const SCRUB_CUSTOM_ATTR = 1;
    const PAGE_NUMBER = 2;
    const PRODUCT_PER_PAGE = 200;
    const PARENT_SKU_CONFIG = array(1, 'ParentSku');
    const ADDITIONAL_IMAGES_CONFIG = array(1, 'AdditionalImages');

    /**
     * @return string
     */
    static protected $defaultStoreId;

    /**
     * Get ID of the default store view.
     *
     * @return string
     */
    static public function getDefaultStoreId()
    {
        if (is_null(self::$defaultStoreId)) {

            self::$defaultStoreId = Mage::app()->getWebsite(true)
                                                ->getDefaultGroup()
                                                ->getDefaultStoreId();
        }

        return self::$defaultStoreId;
    }

    /**
     * Create product collection with test data.
     *
     * @return array
     */
    static public function getTestItems()
    {
        $items = array();
        
        $testCollectionData = array (
            array(
                'id' => 100,
                'name' => 'First' . chr(3),
                'description' => 'First' . chr(19) . 'description',
                'short_description' => 'First\tshort_description',
                'bed_bath_type' => 'First bed_bath_type',
                'camera_megapixels' => 'First' . chr(7),
                'category_ids' => array(1, 2, 3, 4),
                'manufacturer' => self::MANUFACTURER_NAME_CONFIG[2],
                'url_path' => 'url_path',
                'type_id' => 'virtual',
                'visibility' => 4,
                'image' => ''
                
            ),
            array(
                'id' => 200,
                'name' => 'Second',
                'description' => 'Second description',
                'short_description' => 'Second short_description',
                'bed_bath_type' => 'Second bed_bath_type',
                'camera_megapixels' => 'Second',
                'category_ids' => array(1, 2, 3, 4),
                'manufacturer' => 'Sony',
                'url_path' => 'url_path',
                'type_id' => 'simple',
                'visibility' => 1,
                'image' => '/image'
                
            ),
            array(
                'id' => 300,
                'name' => 'Third',
                'description' => 'Third description',
                'short_description' => 'Third short_description',
                'bed_bath_type' => 'Third bed_bath_type',
                'camera_megapixels' => 'Third',
                'category_ids' => array(1, 2, 3, 4),
                'manufacturer' => 'Sony',
                'url_path' => 'url_path',
                'type_id' => 'simple',
                'visibility' => 1,
                'image' => self::ABS_IMAGE_URL_CONFIG[2]
                
            ),
        );

        foreach ($testCollectionData as $productData) {

            $product = Mage::getModel('catalog/product');
            $product->setData($productData);
            $items[] = $product;
        }

        return $items;
    }
}
