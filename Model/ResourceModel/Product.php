<?php
namespace Mager\JoinerTester\Model\ResourceModel;
class Product extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mager_joinertester_product','mager_joinertester_product_id');
    }
}
