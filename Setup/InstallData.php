<?php
namespace Mager\JoinerTester\Setup;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Mager\JoinerTester\Model\ProductFactory $joinProductFactory
     */
    protected $joinProductFactory;

    /**
     * @var \Mager\JoinerTester\Model\ProductRepository $joinProductRepository
     */
    protected  $joinProductRepository;


    /**
     * InstallData constructor.
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Mager\JoinerTester\Model\ProductFactory $joinProductFactory
     * @param \Mager\JoinerTester\Model\ProductRepository $joinProductRepository
     */
    public function __construct
    (
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Mager\JoinerTester\Model\ProductFactory $joinProductFactory,
        \Mager\JoinerTester\Model\ProductRepository $joinProductRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->joinProductFactory = $joinProductFactory;
        $this->joinProductRepository = $joinProductRepository;
    }
    
    
    public function install(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        //install data here
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $productResult = $this->productRepository->getList($searchCriteria);
        if ($productResult->getTotalCount()) {
            $products = $productResult->getItems();
            foreach ($products as $product) {
                $joinProduct = $this->joinProductFactory->create();
                $joinProduct->setProductId($product->getId());
                $joinProduct->setNeedsSync(1);
                $this->joinProductRepository->save($joinProduct);
            }
        }
    }
}
