<?php
namespace AHT\CustomCheckout\Block\Adminhtml\Order;
/**
 * Edit order address form container block
 *
 * @api
 * @since 100.0.2
 */
class Delivery extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $request;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    ) {
        $this->request = $request;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_order';  // tên thư mục sau adminhtml trong block
        $this->_mode = 'delivery';                  // Tên thư mục sau controller và chứa thư mục form
        $this->_blockGroup = 'AHT_CustomCheckout';       //Tên Module
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Order Checkout Custom')); //nút save và tên nút save
        $this->buttonList->remove('delete');
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $address = $this->_coreRegistry->registry('order_delivery');
        $orderId = $address->getOrder()->getIncrementId();
        if ($address->getAddressType() == 'shipping') {
            $type = __('Shipping');
        } else {
            $type = __('Billing');
        }
        return __('Edit Order %1 %2 Address', $orderId, $type);
    }

    protected function getId() {
        $id = $this->request->getParam('order_id');
        return $id;
    }

    /**
     * Back button url getter
     *
     * @return string
     */
    public function getBackUrl()
    {
        $address = $this->_coreRegistry->registry('order_delivery');
        return $this->getUrl('sales/*/view', ['order_id' => $this->getId() ? $this->getId() : null]);
    }
}

