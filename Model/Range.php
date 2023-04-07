<?php
namespace Tesche\RangeProducts\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use \Magento\Catalog\Model\Product\Attribute\Source\Status;
use \Magento\Catalog\Model\Product\Visibility;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Catalog\Helper\Image;

class Range extends AbstractModel
{
    public $_productCollectionFactory;

    protected $_storeManager;

    protected $_imageHelper;

    public function __construct(
        CollectionFactory $_productCollectionFactory,
        StoreManagerInterface $storeManager,
        Image $imageHelper
    ) {
        $this->_productCollectionFactory = $_productCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_imageHelper = $imageHelper;
    }

    public function getFilteredProducts(int $lowRange = 10, int $highRange = 50, string $sort = 'asc')
    {
        $productCollection = $this->_productCollectionFactory->create()
            ->addAttributeToSelect(['thumbnail', 'sku', 'name', 'price', 'qty'])
            ->addAttributeToFilter('status', Status::STATUS_ENABLED)
            ->addAttributeToFilter('visibility', [Visibility::VISIBILITY_BOTH, Visibility::VISIBILITY_IN_CATALOG])
            ->addFieldToFilter('price', array('from' => $lowRange, 'to' => $highRange))
            ->setOrder('price', $sort)
            ->setPageSize(10);

        return $this->buildProductData($productCollection);
    }

    public function buildProductData($productCollection)
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $productsData = [];
        foreach ($productCollection as $product) {
            $productsData[] = [
                'thumbnail' => $mediaUrl . 'catalog/product/cache' . $product->getThumbnail(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'final_price' => $product->getFinalPrice(),
                'url' => $product->getProductUrl(),
                'qty' => $product->getQty()
            ];
        }
        return $productsData;
    }
}
