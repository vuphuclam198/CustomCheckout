<?php
namespace AHT\CustomCheckout\Block;

class Delivery extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    protected $request;
    /**
     * @param \Magento\Sales\Model\ResourceModel\Order
     */
    private $_orderFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        array $data = []
    ) {
        $this->request = $request;
        $this->_orderFactory = $orderFactory;
        parent::__construct($context, $data);
    }

    public function getId()
    {
        $id = $this->request->getParam('order_id');
        return $id;
    }

    public function getProduct() {
        $id = $this->getId();
       return $product = $this->_orderFactory->create()->load($id);
    }

    public function getDeliveryEditLink($label = '')
    {
        // if ($this->_authorization->isAllowed('Magento_Sales::actions_edit')) {
            if (empty($label)) {
                $label = __('Edit');    
            }
            $url = $this->getUrl('delivery/order/delivery', ['order_id' => $this->getProduct()->getEntityId()]);
            return '<a href="' . $this->escapeUrl($url) . '">' . $this->escapeHtml($label) . '</a>';
        // }

    }

    
}
