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
 * Class WordStream_Services_Model_Catalog_Product_ProductsData retrieve data of products.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_BaseProductsData extends Mage_Catalog_Model_Product_Api
{
    /**
     * @var Mage_Catalog_Model_Resource_Product_Collection
     */
    protected $_productCollection;

    /**
     * Get the collection for retrieving products data.
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getProductCollection()
    {
        if (is_null($this->_productCollection)) {

            $this->_productCollection = Mage::getModel('catalog/product')->getCollection();
        }

        return $this->_productCollection;
    }

    /**
     * Filter the collection by store.
     *
     * @param int|string $store
     * return void
     */
    protected function filterByStore($store)
    {
        $this->getProductCollection()->addStoreFilter($store);
    }

    /**
     * Filter the collection by stock quantity.
     *
     * @param int|string $stockQuantityFilterAmount
     * return void
     */
    protected function filterByStockQuantity($stockQuantityFilterAmount)
    {
        $this->getProductCollection()
            ->joinField(
                'qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left'
            )
            ->addAttributeToFilter('qty', array('gteq' => $stockQuantityFilterAmount));
    }

    /**
     * Add filters to the product collection.
     *
     * @param array $filters
     * @return void
     */
	protected function addFilters($filters)
    {
        $collection = $this->getProductCollection();

        if (is_array($filters)) {
            try {
                foreach ($filters as $field => $value) {

                    if (isset($this->_filtersMap[$field])) {

                        $field = $this->_filtersMap[$field];
                    }

                    $collection->addFieldToFilter($field, $value);
                }
            } catch (Mage_Core_Exception $e) {
                $this->_fault('filters_invalid', $e->getMessage());
            }
        }
	}
}
