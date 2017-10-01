<?php
namespace Mager\JoinerTester\Api;

use Mager\JoinerTester\Api\Data\ProductInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductRepositoryInterface 
{
    public function save(ProductInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(ProductInterface $page);

    public function deleteById($id);
}
