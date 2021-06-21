<?php
namespace AHT\CustomCheckout\Controller\Delivery;

class Post extends \Magento\Framework\App\Action\Action
{
    // /**
    //  * @param \Magento\Sales\Model\OrderFactory
    //  */
    private $orderModel;

    // /**
    //  * @param \Magento\Sales\Model\ResourceModel\Order
    //  */
    private $orderResourceModel;

    /**
     * @param \Magento\Checkout\Model\Session
     */
    private $modelSession;

    // /**
    //  * @var \Magento\Framework\View\Result\PageFactory
    //  */

    // /**
    //  * @param \Magento\Framework\App\Action\Context $context
    //  */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\OrderFactory $orderModel,
        \Magento\Sales\Model\OrderFactory $orderResourceModel,
        \Magento\Checkout\Model\Session $modelSession
    )
    {
        $this->orderModel = $orderModel;
        $this->orderResourceModel = $orderResourceModel;
        $this->modelSession = $modelSession;
        return parent::__construct($context);
    }
    // /**
    //  * View page action
    //  *
    //  * @return \Magento\Framework\Controller\ResultInterface
    //  */
    public function execute()
    {
        $data = $this->getRequest()->getContent();
        $delivery = $this->orderResourceModel->create()->load(12);
        var_dump($delivery->getDeliveryDate());
    }
}
