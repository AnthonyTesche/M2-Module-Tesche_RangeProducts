<?php

/**
 * Range Controller for displaying products within a certain price range
 *
 * @category  Controller
 * @package   Tesche\RangeProducts\Controller\Index
 * @author    Anthony Tesche
 */

namespace Tesche\RangeProducts\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Range extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Range constructor.
     *
     * @param Context $context
     * 
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute Range controller
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Products Range'));

        $block = $resultPage->getLayout()->getBlock('customer.account.link.back');
        if ($block) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        return $resultPage;
    }
}
