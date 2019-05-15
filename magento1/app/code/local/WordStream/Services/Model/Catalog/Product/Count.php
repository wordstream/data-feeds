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
 * Class WordStream_Services_Model_Catalog_Product_Count retrieve count of products.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_Count
    extends WordStream_Services_Model_Catalog_Product_BaseProductsData
{
	/**
     * Retrieve products count.
     *
     * @param array $filters
     * @param int|string $stockQuantityFilterAmount
     * @param int|string $store
     * @return int
     */
	public function count($filters, $stockQuantityFilterAmount, $store)
	{
        $collection = $this->getProductCollection($store);
        $this->filterByStore($store);
        $this->filterByStockQuantity($stockQuantityFilterAmount);
        $this->addFilters($filters);

		return (int) $collection->getSize();
    }
}