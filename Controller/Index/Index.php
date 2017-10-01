<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mager\JoinerTester\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Mager\Joiner\Model\JoinerFactory $joinerFactory
     */
    protected $joinerFactory;


    /**
     * Index constructor.
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param \Mager\Joiner\Model\JoinerFactory $joinerFactory
     */
    public function __construct
    (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Mager\Joiner\Model\JoinerFactory $joinerFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->joinerFactory = $joinerFactory;
        parent::__construct($context);
    }
    
    /**
     * Index action
     *
     * @return $this
     */
    public function execute()
    {
        echo '<p>starting joiner test...</p>';

        /**
         * @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
         */
        $productCollection = $this->collectionFactory->create();

        /**
         * @var \Mager\Joiner\Model\Joiner $joiner
         */
        $joiner = $this->joinerFactory->create($productCollection);
        
        $joiner->joinTablename('mager_joinertester_product');
        $joiner->joinOn(['row_id' => 'product_id']);
        $joiner->joinSelectFields('needs_sync');
        $joiner->call();
        
        $this->renderJoinResults($productCollection);
        
        echo '<p>finished joiner test.</p>';
    }

    /**
     * Render the results of the join (aka product ID and the joined needs_sync column)
     * 
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     */
    protected function renderJoinResults(\Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection)
    {
        echo "<ul>";
        foreach ($productCollection as $product) {
            echo "<li>Product ID " . $product->getId() . " Needs Sync? " . ($product->getNeedsSync() ? "1" : "0") . "</li>";
        }
        echo "</ul>";
    }
}
