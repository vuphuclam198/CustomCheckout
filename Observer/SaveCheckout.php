<?php
namespace AHT\CustomCheckout\Observer;

class SaveCheckout implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Checkout\Model\Session
     */
    private $_checkoutSession;

    /**
     * @param \Magento\Sales\Model\ResourceModel\Order
     */
    private $_orderFactory;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\ResourceModel\Order $orderFactory
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory = $orderFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getData('order');
        $date = $this->_checkoutSession->getDate();
        $comment = $this->_checkoutSession->getComment();
        $order->setData('delivery_date', $date);
        $order->setData('delivery_comment', $comment);
        $order->save();
    }
}