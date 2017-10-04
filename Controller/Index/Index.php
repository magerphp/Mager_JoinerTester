<?php

namespace Mager\JoinerTester\Controller\Index;

use Exception;
use Mager\Joiner\Exception\JoinerParamAlreadySetException;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var \Mager\Joiner\Model\JoinerFactory $joinerFactory
     */
    protected $joinerFactory;


    /**
     * Index constructor.
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Mager\Joiner\Model\JoinerFactory $joinerFactory
     */
    public function __construct
    (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Mager\Joiner\Model\JoinerFactory $joinerFactory
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
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
        $productCollection = $this->productCollectionFactory->create();
        
        try {
            /**
             * @var \Mager\Joiner\Model\Joiner $joiner
             */
            $joiner = $this->joinerFactory->create();
            $joiner->setCollection($productCollection);
            $joiner->setJoinTablename('mager_joinertester_product');
            $joiner->setJoinOn('product_id = entity_id');
            $joiner->setJoinSelectFields(['needs_sync']);
            $joiner->commit();
            $this->renderJoinResults($productCollection);
        } catch (JoinerParamAlreadySetException $jpase) {
            echo "<b>ya done messed up by attempting to reset the " . $jpase->getMessage() . "</b>";
        } catch (Exception $e) {
            echo "<b>ya done messed up: " . $e->getMessage() . "</b>";
        }
        
        
        // todo now test it with a non-eav collection!
        
        // todo find/make another table to join to (from a collection of mager_joinertester_product?)
        
        
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
