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
 * Class WordStream_Services_Model_Catalog_Product_ExtendedList retrieve data of products.
 * @package WordStream_Services
 * @author wordstream
 */
class WordStream_Services_Model_Catalog_Product_ExtendedList
    extends WordStream_Services_Model_Catalog_Product_BaseProductsData
{
    /**
     * @var string
     */
	const PRODUCT_NAME_ATTRIBUTE = 'name';
	const DESCRIPTION_ATTRIBUTE = 'description';
	const SHORT_DESCRIPTION_ATTRIBUTE = 'short_description';
	const CATEGORY_NAME_ATTRIBUTE = 'name';
	const MANUFACTURER_ATTRIBUTE = 'manufacturer';
	const VISIBILITY_ATTRIBUTE = 'visibility';
    const URL_PATH_ATTRIBUTE = 'url_path';
    const IMAGE_ATTRIBUTE = 'image';
	const CATEGORY_SEPARATOR = ' > ';

    /**
     * @var Mage_CatalogInventory_Model_Stock_Item
     */
    protected $_stockItemModel;

    /**
     * @var Mage_Eav_Model_Entity_Attribute_Set
     */
    protected $_attributeSetModel;

    /**
     * @var Mage_Catalog_Model_Category
     */
    protected $_categoryModel;

    /**
     * @var Mage_Catalog_Model_Product_Type_Configurable
     */
    protected $_configurableTypeModel;

    /**
     * @var Mage_Catalog_Model_Product_Type_Grouped
     */
    protected $_groupedTypeModel;

    /**
     * @var Mage_Catalog_Model_Product
     */
    protected $_productModel;

    /**
     * @var array
     */
    protected $_resultItem;

    /**
     * Retrieve products data for requested store with speciefed filters.
     *
     * @param array $filters
     * @param int|string $stockQuantityFilterAmount
     * @param int|string $store
     * @param array $attributes
     * @param array $customAttributes
     * @param array $qtyConfig
     * @param array $isInStockConfig
     * @param array $attributeSetNameConfig
     * @param array $categoryBreadCrumbConfig
     * @param array $manufacturerNameConfig
     * @param array $absoluteUrlConfig
     * @param array $absoluteImageUrlConfig
     * @param int $scrubProductName
     * @param int $scrubDescription
     * @param int $scrubShortDescription
     * @param int $scrubAttributeSetName
     * @param int $scrubCustomAttribute
     * @param int|string $pageNumber
     * @param int|string $productsPerPage
     * @param array $parentSKUConfig
     * @param array $additionalImagesConfig
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

        $storeId = (int) $this->_getStoreId($store);
        $collection = $this->getProductCollection();

        $this->prepareProductCollection(
            $storeId,
            $filters,
            $stockQuantityFilterAmount,
            $attributes,
            $customAttributes,
            $manufacturerNameConfig,
            $absoluteUrlConfig,
            $absoluteImageUrlConfig,
            $pageNumber,
            $productsPerPage
        );

        $resultItems = array();

        foreach ($collection->getItems() as $product) {

            $this->prepareProductData(
                $product,
                $storeId,
                $attributes,
                $customAttributes,
                $scrubCustomAttribute,
                $scrubProductName,
                $scrubDescription,
                $scrubShortDescription,
                $scrubAttributeSetName,
                $qtyConfig,
                $isInStockConfig,
                $attributeSetNameConfig,
                $categoryBreadCrumbConfig,
                $manufacturerNameConfig,
                $parentSKUConfig,
                $absoluteUrlConfig,
                $absoluteImageUrlConfig,
                $additionalImagesConfig
            );

            $resultItems[] = $this->_resultItem;
        }

		return $resultItems;
    }


    /**
     * Prepare product collection.
     * @param $storeId
     * @param $filters
     * @param $stockQuantityFilterAmount
     * @param $attributes
     * @param $customAttributes
     * @param $manufacturerNameConfig
     * @param $absoluteUrlConfig
     * @param $absoluteImageUrlConfig
     * @param $pageNumber
     * @param $productsPerPage
     */
	protected function prepareProductCollection(
        $storeId,
        $filters,
        $stockQuantityFilterAmount,
        $attributes,
        $customAttributes,
        $manufacturerNameConfig,
        $absoluteUrlConfig,
        $absoluteImageUrlConfig,
        $pageNumber,
        $productsPerPage
    ) {
        $collection = $this->getProductCollection();
        $this->filterByStore($storeId);
        $this->filterByStockQuantity($stockQuantityFilterAmount);
        $this->addFilters($filters);

        $preparedAttributes = $this->getPreparedAttributes(
            $attributes,
            $customAttributes,
            $manufacturerNameConfig,
            $absoluteUrlConfig,
            $absoluteImageUrlConfig
        );

        $this->addAttributes($preparedAttributes);

        if($pageNumber != 0) {
			$collection->setPage($pageNumber, $productsPerPage);
		}
	}

    /**
     * Add attributes to the select query.
     *
     * @param array $attributes
     * @return void
     */
	protected function addAttributes($attributes)
    {
        try {
            $this->getProductCollection()->addAttributeToSelect($attributes);
        } catch (Mage_Core_Exception $exception) {
            $this->_fault('attributes_invalid', $exception->getMessage());
        }
	}

    /**
     * Add attributes to the select query.
     *
     * @param array $attributes
     * @param array $customAttributes
     * @return array
     */
	protected function getPreparedAttributes(
        $attributes,
        $customAttributes,
        $manufacturerNameConfig,
        $absoluteUrlConfig,
        $absoluteImageUrlConfig
    ) {
        $prepareAttributes = array();

		if (is_array($attributes)) {
            $prepareAttributes = array_merge($prepareAttributes, array_values($attributes));
        }

		if (is_array($customAttributes)) {
			$prepareAttributes = array_merge($prepareAttributes, array_values($customAttributes));
		}

		if ($manufacturerNameConfig[0]) {
			$prepareAttributes[] = self::MANUFACTURER_ATTRIBUTE;
		}

		if ($absoluteUrlConfig[0]) {
			$prepareAttributes[] = self::URL_PATH_ATTRIBUTE;
		}

		if ($absoluteImageUrlConfig[0]) {
			$prepareAttributes[] = self::IMAGE_ATTRIBUTE;
		}

		if ($absoluteUrlConfig[0] || $absoluteImageUrlConfig[0]) {
			$prepareAttributes[] = self::VISIBILITY_ATTRIBUTE;
		}

		return array_unique($prepareAttributes);
	}

    /**
     * Preparing data for the response.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $attributes
     * @return void
     */
	protected function prepareProductData(
        $product,
        $storeId,
        $attributes,
        $customAttributes,
        $scrubCustomAttribute,
        $scrubProductName,
        $scrubDescription,
        $scrubShortDescription,
        $scrubAttributeSetName,
        $qtyConfig,
        $isInStockConfig,
        $attributeSetNameConfig,
        $categoryBreadCrumbConfig,
        $manufacturerNameConfig,
        $parentSKUConfig,
        $absoluteUrlConfig,
        $absoluteImageUrlConfig,
        $additionalImagesConfig
    ) {
        $this->_resultItem = array();
        $this->getStandardAttributes(
            $product,
            $attributes,
            $scrubProductName,
            $scrubDescription,
            $scrubShortDescription
        );
        $this->getCustomAttributes($product, $customAttributes, $scrubCustomAttribute);
        $this->getStockAttributes($product, $qtyConfig, $isInStockConfig);
        $this->getAttributeSet($product, $attributeSetNameConfig, $scrubAttributeSetName);
        $this->getCategoryBreadCrumb($product, $categoryBreadCrumbConfig, $storeId);
        $this->getManufacturer($product, $manufacturerNameConfig);
        $parentIds = $this->getParentIds($product, $parentSKUConfig, $absoluteUrlConfig, $absoluteImageUrlConfig);
        $this->getUrlAndImage($product, $absoluteUrlConfig, $absoluteImageUrlConfig, $parentIds, $storeId);
        $this->getParentSku($product, $parentSKUConfig, $parentIds);
        $this->getAdditionalImages($product, $additionalImagesConfig);
	}

    /**
     * Getting standard attributes.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $attributes
     * @param mixed $scrubProductName
     * @param mixed $scrubDescription
     * @param mixed $scrubShortDescription
     * @return void
     */
	protected function getStandardAttributes(
        $product,
        $attributes,
        $scrubProductName,
        $scrubDescription,
        $scrubShortDescription
    ) {
        if (!empty($attributes) && is_array($attributes)) {

            foreach ($attributes as $attribute) {

                // Scrub attribute value if it's needed.
                if (($attribute == self::PRODUCT_NAME_ATTRIBUTE && $scrubProductName)
                    || ($attribute == self::DESCRIPTION_ATTRIBUTE && $scrubDescription)
                    || ($attribute == self::SHORT_DESCRIPTION_ATTRIBUTE && $scrubShortDescription)) {

                     $this->_resultItem[$attribute] = $this->scrubData($product->getData($attribute));

                } else {

                    $this->_resultItem[$attribute] = $product->getData($attribute);
                }
            }
        }
	}

    /**
     * Getting custom attributes.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $customAttributes
     * @param int $scrubCustomAttribute
     * @return void
     */
	protected function getCustomAttributes($product, $customAttributes, $scrubCustomAttribute)
	{
        if (!empty($customAttributes) && is_array($customAttributes)) {

            foreach ($customAttributes as $customAttribute) {

                $attributeField = $product->getResource()->getAttribute($customAttribute);

                //If it's an option or multiselect attribute
                if (!empty($attributeField)
                        && $attributeField->usesSource()
                        && $product->getAttributeText($customAttribute)) {

                    $attributeFieldValue = $product->getAttributeText($customAttribute);

                } else {

                    $attributeFieldValue = $product->getData($customAttribute);
                }

                if ($scrubCustomAttribute) {

                    $attributeFieldValue = $this->scrubData($attributeFieldValue);
                }

                $this->_resultItem[$customAttribute] = $attributeFieldValue;
            }
        }
	}

    /**
     * Getting stock attributes.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $qtyConfig
     * @param array $isInStockConfig
     * @return void
     */
	protected function getStockAttributes($product, $qtyConfig, $isInStockConfig)
    {
        if ($qtyConfig[0] || $isInStockConfig[0]) {

            $inventoryStatus = $this->getStockItemModel()->loadByProduct($product);

            if (!empty($inventoryStatus)) {

                if ($qtyConfig[0]) {

                    $responseField = $qtyConfig[1];
                    $this->_resultItem[$responseField] = $inventoryStatus->getQty();
                }

                if ($isInStockConfig[0]) {

                    $responseField = $isInStockConfig[1];
                    $this->_resultItem[$responseField] = $inventoryStatus->getIsInStock();
                }
            }
        }
	}

    /**
     * Get the stock model for retrieving product stock data.
     *
     * @return Mage_CatalogInventory_Model_Stock_Item
     */
    protected function getStockItemModel()
    {
        if (is_null($this->_stockItemModel)) {

            $this->_stockItemModel = Mage::getModel('cataloginventory/stock_item');
        } else {
            $this->_stockItemModel->clearInstance();
        }

        return $this->_stockItemModel;
    }

    /**
     * Get attribute set data.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $attributeSetNameConfig
     * @param int $scrubAttributeSetName
     * @return void
     */
	protected function getAttributeSet($product, $attributeSetNameConfig, $scrubAttributeSetName)
	{
        if ($attributeSetNameConfig[0]) {

            $attributeSet = $this->getAttributeSetModel()->load($product->getAttributeSetId());

            if ($attributeSet->getId()) {

                $attributeSetName = $attributeSet->getAttributeSetName();

                if ($scrubAttributeSetName) {

                    $attributeSetName = $this->scrubData($attributeSetName);
                }

                $responseField = $attributeSetNameConfig[1];
                $this->_resultItem[$responseField] = $attributeSetName;
            }
        }
	}

    /**
     * Get the attribute set model for retrieving products data.
     *
     * @return Mage_Eav_Model_Entity_Attribute_Set
     */
    protected function getAttributeSetModel()
    {
        if (is_null($this->_attributeSetModel)) {

            $this->_attributeSetModel = Mage::getModel('eav/entity_attribute_set');
        } else {
            $this->_attributeSetModel->clearInstance();
        }

        return $this->_attributeSetModel;
    }

    /**
     * Get category breadcrambs.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $categoryBreadCrumbConfig
     * @param int $storeId
     * @return void
     */
	protected function getCategoryBreadCrumb($product, $categoryBreadCrumbConfig, $storeId)
	{
        if ($categoryBreadCrumbConfig[0]) {

            $categoryIds = $product->getCategoryIds();

            if (!empty($categoryIds)) {

                $categoryBreadcrumb = '';

                foreach ($categoryIds as $categoryId) {

                    $category = $this->getCategoryModel()->setStoreId($storeId)->load($categoryId);

                    if ($category->getId()) {
                        $categoryName = $category->getData(self::CATEGORY_NAME_ATTRIBUTE);
                        $categoryBreadcrumb .= $categoryName . self::CATEGORY_SEPARATOR;
                    }
                }

                $categoryBreadcrumb = trim($categoryBreadcrumb, self::CATEGORY_SEPARATOR);

                $responseField = $categoryBreadCrumbConfig[1];
                $this->_resultItem[$responseField] = $categoryBreadcrumb;
            }
        }
	}

    /**
     * Get the category model for retrieving products data.
     *
     * @return Mage_Catalog_Model_Category
     */
    protected function getCategoryModel()
    {
        if (is_null($this->_categoryModel)) {

            $this->_categoryModel = Mage::getModel('catalog/category');
        } else {
            $this->_categoryModel->clearInstance();
        }

        return $this->_categoryModel;
    }

    /**
     * Get manufacturer.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $manufacturerNameConfig
     * @return void
     */
	protected function getManufacturer($product, $manufacturerNameConfig)
	{
        if ($manufacturerNameConfig[0]) {

            $manufacturer = $product->getResource()->getAttribute(self::MANUFACTURER_ATTRIBUTE);

            if (!empty($manufacturer)) {

                $manufacturerName = $manufacturer->getFrontend()->getValue($product);
                $manufacturerNameNullValue = $manufacturerNameConfig[2];

                if (empty($manufacturerName) || $manufacturerName == $manufacturerNameNullValue) {
                    $manufacturerName = '';
                }

                $responseField = $manufacturerNameConfig[1];
                $this->_resultItem[$responseField] = $manufacturerName;
            }
        }
	}

    /**
     * Get configurable products parent IDs,
     * we need to retrieve parent ids if either of the following fields are requested :
     * - absolute url
     * - absolute image url
     * - parent SKU
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $parentSKUConfig
     * @param array $absoluteUrlConfig
     * @param array $absoluteImageUrlConfig
     * @return array
     */
	protected function getParentIds($product, $parentSKUConfig, $absoluteUrlConfig, $absoluteImageUrlConfig)
	{
        $ids = array();

        if ($parentSKUConfig[0] || $absoluteUrlConfig[0] || $absoluteImageUrlConfig[0]) {

            $ids = $this->getConfigurableTypeModel()->getParentIdsByChild($product->getId());
        }

        return $ids;
	}

    /**
     * Get the configurable product model for retrieving products data.
     *
     * @return Mage_Catalog_Model_Product_Type_Configurable
     */
    protected function getConfigurableTypeModel()
    {
        if (is_null($this->_configurableTypeModel)) {

            $this->_configurableTypeModel = Mage::getModel('catalog/product_type_configurable');
        }

        return $this->_configurableTypeModel;
    }

    /**
     * Get absolute URL & image.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $absoluteUrlConfig
     * @param array $absoluteImageUrlConfig
     * @param array $parentIds
     * @param int $storeId
     * @return void
     */
	protected function getUrlAndImage($product, $absoluteUrlConfig, $absoluteImageUrlConfig, $parentIds, $storeId)
	{
        if ($absoluteUrlConfig[0] || $absoluteImageUrlConfig[0]) {

            $productUrl = $product->getUrlPath();
            $productImage = $product->getImage();
            $store = Mage::getModel('core/store')->load($storeId);
            $baseUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$imageBaseURL = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product';

            $noSelectionValue = $absoluteImageUrlConfig[2];

            //If it's a simple product and it's NOT visible then we are getting
            //the URL/ImageURL from the parent (configurable/grouped) product.
            if ($product->getTypeId() == 'simple'
                    && $product->getVisibility() == 1) {

                //Checking if the product is a child of a "grouped" product
                if (sizeof($parentIds) < 1) {
                    $parentIds = $this->getGroupedTypeModel()->getParentIdsByChild($product->getId());
                }

                //Setting the URL SEO to the parent URL if a parent is found
                if (isset($parentIds[0])) {

                    $firstParentProduct = $this->getProductModel()->load($parentIds[0]);
                    $productUrl = $firstParentProduct->getUrlPath();

                    if ($productImage == '' || $productImage == $noSelectionValue) {
                        $productImage = $firstParentProduct->getImage();
                    }
                //Blanking-out the URL/Image URL since items that are not visible and are not associated with a parent
                } else {
                    $productUrl = null;
                    $productImage = null;
                }
            }

            if ($absoluteUrlConfig[0] && !empty($productUrl)) {

                $responseField = $absoluteUrlConfig[1];
                $this->_resultItem[$responseField] = $baseUrl . $productUrl;
            }

            if ($absoluteImageUrlConfig[0] && !empty($productImage) && $productImage != $noSelectionValue) {

                $responseField = $absoluteImageUrlConfig[1];
                $this->_resultItem[$responseField] = $imageBaseURL . $productImage;
            }
        }
	}

    /**
     * Get the grouped product model for retrieving products data.
     *
     * @return Mage_Catalog_Model_Product_Type_Grouped
     */
    protected function getGroupedTypeModel()
    {
        if (is_null($this->_groupedTypeModel)) {

            $this->_groupedTypeModel = Mage::getModel('catalog/product_type_grouped');
        }

        return $this->_groupedTypeModel;
    }

    /**
     * Get the product model for retrieving products data.
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function getProductModel()
    {
        if (is_null($this->_productModel)) {

            $this->_productModel = Mage::getModel('catalog/product');
        } else {
            $this->_productModel->clearInstance();
        }

        return $this->_productModel;
    }

    /**
     * Get configurable product parent SKU.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $parentSKUConfig
     * @param array $parentIds
     * @return void
     */
	protected function getParentSku($product, $parentSKUConfig, $parentIds)
	{
        if ($parentSKUConfig[0]) {

            $parentSKUS = array();

            foreach ($parentIds as $parentId) {

                $parentSKUS[] = $this->getProductModel()->load($parentId)->getSku();
            }

            $responseField = $parentSKUConfig[1];
            $this->_resultItem[$responseField] = $parentSKUS;
        }
	}


    /**
     * Get additional images.
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $additionalImagesConfig
     * @return void
     */
	protected function getAdditionalImages($product, $additionalImagesConfig)
	{
        if ($additionalImagesConfig[0]) {

            $additionalImageURLs = array();

            foreach ($this->getProductModel()->load($product->getId())->getMediaGalleryImages() as $image) {
                $additionalImageURLs[] = $image['url'];
            }

            $responseField = $additionalImagesConfig[1];
            $this->_resultItem[$responseField] = $additionalImageURLs;
        }
	}

    /**
     * Scrubbing various unwanted characters.
     *
     * @return array
     */
	protected function scrubData($fieldValue)
	{
        foreach ($this->getMapOfScrubbing() as $replaceWith => $unwantedCharacters) {

            $fieldValue = str_replace($unwantedCharacters, $replaceWith, $fieldValue);
        }

		return $fieldValue;
	}

    /**
     * Get the replacing map of unwanted characters.
     *
     * @return array
     */
    protected function getMapOfScrubbing()
    {
        return array(
            '' => array(
                chr(1),
                chr(2),
                chr(3),
                chr(4),
                chr(5),
                chr(6),
                chr(7),
            ),
            ' ' => array(
                chr(10),
                chr(11),
                chr(13),
                chr(17),
                chr(18),
                chr(19),
                chr(20),
                chr(21),
                chr(22),
                chr(23),
                chr(24),
                chr(25),
                chr(26),
                chr(27),
                chr(28),
                chr(29),
                chr(30),
                chr(31),
                '\r',
                '\n',
                '\r\n',
            ),
            '    ' => array('\t'),
        );
    }
}