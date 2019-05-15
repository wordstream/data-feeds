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
 * Class WordStream_Services_Model_Catalog_Product_Api retrieve data for request.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_Api
{
    /**
     * @var WordStream_Services_Model_Catalog_Product_Count
     */
    protected $_countModel;

    /**
     * @var WordStream_Services_Model_Catalog_Product_ExtendedList
     */
    protected $_extendedListModel;

    /**
     * Get the object for retrieving count of products.
     *
     * @return WordStream_Services_Model_Catalog_Product_Count
     */
	public function getCountModel()
	{
        if (is_null($this->_countModel)) {

            $this->_countModel = Mage::getModel('wordstream_services/catalog_product_count');
        }

		return $this->_countModel;
    }

    /**
     * Get the object for retrieving List of products.
     *
     * @return WordStream_Services_Model_Catalog_Product_ExtendedList
     */
	public function getExtendedListModel()
	{
        if (is_null($this->_extendedListModel)) {

            $this->_extendedListModel = Mage::getModel('wordstream_services/catalog_product_extendedList');
        }

		return $this->_extendedListModel;
    }

    /**
     * Retrieve products count.
     *
     * @param array $filters
     * @param int|string $stockQuantityFilterAmount
     * @param int|string $store
     * @param string $responseField
     * @return array
     */
	public function count($filters, $stockQuantityFilterAmount, $store, $responseField)
	{
        $count = $this->getCountModel()->count($filters, $stockQuantityFilterAmount, $store);

		return array(
            $responseField => $count,
        );
    }

    /**
     * Retrieve products count.
     * @param $filters
     * @param $stockQuantityFilterAmount
     * @param $store
     * @param $attributes
     * @param $customAttributes
     * @param $qtyConfig
     * @param $isInStockConfig
     * @param $attributeSetNameConfig
     * @param $categoryBreadCrumbConfig
     * @param $manufacturerNameConfig
     * @param $absoluteUrlConfig
     * @param $absoluteImageUrlConfig
     * @param $scrubProductName
     * @param $scrubDescription
     * @param $scrubShortDescription
     * @param $scrubAttributeSetName
     * @param $scrubCustomAttribute
     * @param $pageNumber
     * @param $productsPerPage
     * @param $parentSKUConfig
     * @param $additionalImagesConfig
     *
     * @return array
     */
	public function extendedList(
		$filters,
		$stockQuantityFilterAmount,
		$store,
		$attributes,
		$customAttributes,
		$qtyConfig,
		$isInStockConfig,
		$attributeSetNameConfig,
		$categoryBreadCrumbConfig,
		$manufacturerNameConfig,
		$absoluteUrlConfig,
		$absoluteImageUrlConfig,
		$scrubProductName,
		$scrubDescription,
		$scrubShortDescription,
		$scrubAttributeSetName,
		$scrubCustomAttribute,
		$pageNumber,
		$productsPerPage,
		$parentSKUConfig,
        $additionalImagesConfig
    ) {
		return $this->getExtendedListModel()
                    ->extendedList(
                        $filters,
                        $stockQuantityFilterAmount,
                        $store,
                        $attributes,
                        $customAttributes,
                        $qtyConfig,
                        $isInStockConfig,
                        $attributeSetNameConfig,
                        $categoryBreadCrumbConfig,
                        $manufacturerNameConfig,
                        $absoluteUrlConfig,
                        $absoluteImageUrlConfig,
                        $scrubProductName,
                        $scrubDescription,
                        $scrubShortDescription,
                        $scrubAttributeSetName,
                        $scrubCustomAttribute,
                        $pageNumber,
                        $productsPerPage,
                        $parentSKUConfig,
                        $additionalImagesConfig
                    );
    }
}
