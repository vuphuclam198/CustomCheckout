<?php
namespace AHT\CustomCheckout\Controller\Delivery;

class Checkout extends \Magento\Framework\App\Action\Action
{

    /**
     * @param \Magento\Checkout\Model\Session
     */
    private $_checkoutSession;

    protected $json;
    protected $resultJsonFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Serialize\Serializer\Json $json

    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->json = $json;

        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getContent();
        $response = $this->json->unserialize($data);
        $date = $response['date'];
        $comment = $response['comment'];
        
        $this->setDate($date);
        $this->setComment($comment);
        // $dataCheckout = new \Magento\Framework\DataObject(array(
        //     'date' => $this->setDate($date),
        //     'comment' => $this->setComment($comment)
        // ));
		// $this->_eventManager->dispatch('checkout_onepage_controller_success_action', ['data' => $dataCheckout]);
        // exit;
        
    }

    public function setDate($date) {
        $this->_checkoutSession->setDate($date);
    }

    public function setComment($comment) {
        $this->_checkoutSession->setComment($comment);
    }
}
