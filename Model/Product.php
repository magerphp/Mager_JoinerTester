<?php
namespace Mager\JoinerTester\Model;
class Product extends \Magento\Framework\Model\AbstractModel implements \Mager\JoinerTester\Api\Data\ProductInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'mager_joinertester_product';

    protected function _construct()
    {
        $this->_init('Mager\JoinerTester\Model\ResourceModel\Product');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
