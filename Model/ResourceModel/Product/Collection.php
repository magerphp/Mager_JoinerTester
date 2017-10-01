<?php
namespace Mager\JoinerTester\Model\ResourceModel\Product;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Mager\JoinerTester\Model\Product','Mager\JoinerTester\Model\ResourceModel\Product');
    }
}
