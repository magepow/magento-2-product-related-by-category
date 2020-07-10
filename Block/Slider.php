<?php

namespace Magepow\Productslider\Block;

// class Slider extends \Magento\Catalog\Block\Product\AbstractProduct
class Slider extends \Magento\Catalog\Block\Product\ListProduct
{
    
    public function getCurrentCategory()
    {        
        return $this->_coreRegistry->registry('current_category');
    }
    
    public function getCurrentProduct()
    {        
        return $this->_coreRegistry->registry('current_product');
    }    


    protected function _getProductCollection()
    {
        $limit = $this->_scopeConfig->getValue(
            'magepow_productslider/general/limit',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $categoryId = $this->getCategoryId();
        if (is_null($this->_productCollection)) {
            $this->setCategoryId($categoryId);
            $this->_productCollection = parent::_getProductCollection();   
        }

        return  $this->_productCollection->setPageSize($limit);
    }

    public function getCategoryId()
    {
        $category = $this->getCurrentProduct();

        $categoryId = $category ? $category->getId() : 0;
        if($categoryId) return $categoryId;

        $product = $this->getCurrentProduct();
        if($product){
            $categories = $product->getCategoryIds();
            foreach($categories as $category){
                $categoryId = $category;
                break;
            }
        }
        return $categoryId;
    }

    
}