<?php

/**
 * Range Controller for handling the product filtering
 *
 * @category  Controller
 * @package   Tesche\RangeProducts\Controller\Form
 * @author    Anthony Tesche
 */

declare(strict_types=1);

namespace Tesche\RangeProducts\Controller\Form;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Tesche\RangeProducts\Model\Range as RangeModel;

/**
 * Class Range
 * @package Tesche\RangeProducts\Controller\Form
 */
class Range extends Action
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RangeModel
     */
    protected $rangeModel;

    /**
     * Range constructor.
     *
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param ManagerInterface $messageManager
     * @param RangeModel $rangeModel
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        ManagerInterface $messageManager,
        RangeModel $rangeModel
    ) {
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
        $this->rangeModel = $rangeModel;
        parent::__construct($context);
    }

    /**
     * Range Controller execute function
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $data = [];
        
        if ($this->validate($params)) {
            $data = $this->rangeModel->getFilteredProducts(
                (int) $params['low-range'],
                (int) $params['high-range'],
                $params['sort']
            );
        } else {
            $data = ['error' => 'The search can be performed with a maximum of 5x the minimum value selected'];
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($data);
        return $resultJson;
    }

    /**
     * Validates the low and high ranges to ensure they are within an acceptable range.
     *
     * @param array $params
     * 
     * @return bool
     */
    public function validate($params)
    {
        if (!empty($params)) {
            if ($params['low-range'] * 5 >= $params['high-range']){
                return true;
            }
        }
        return false;
    }
}
