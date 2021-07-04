<?php
namespace AHT\CustomCheckout\Controller\Adminhtml\Order;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'AHT_CustomCheckout::save';

    const PAGE_TITLE = 'Page Title';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Sales\Model\OrderFactory
     */
    private $_orderFactory;

    /**
     * @param \Magento\Framework\Controller\Result\RedirectFactory
     */
    private $_redirectFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Magento\Framework\Controller\ResultFactory $resultFactory,
       \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->resultFactory = $resultFactory;
        $this->_orderFactory = $orderFactory;
        $this->_redirectFactory = $redirectFactory;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
         /** @var \Magento\Framework\View\Result\Page $resultPage */

         if (!empty($this->getOrderId())) {
            try {
                $orderId = $this->getOrderId();
                $order = $this->_orderFactory->create()->load($orderId);
                $order->setDeliveryDate($_POST['delivery_date']);
                $order->save();
                $redirect = $this->_redirectFactory->create();
                $redirect->setPath('sales/*/view', ['order_id' => $this->getOrderId() ? $this->getOrderId() : null]);
                $this->messageManager->addSuccess(__('Update thành công'));
                return $redirect;
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        } else {
            $this->_messageManager->addError(__("Error Message"));
        }
         
    }

    public function getOrderId()
    {
        return $this->getRequest()->getParam('order_id');
    }
    /**
     * Is the user allowed to view the page.
    *
    * @return bool
    */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
