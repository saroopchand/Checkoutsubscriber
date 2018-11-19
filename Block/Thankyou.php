<?php
namespace Progos\Checkoutsubscriber\Block;

class Thankyou extends \Magento\Sales\Block\Order\Totals
{
    protected $checkoutSession;
    protected $customerSession;
    protected $_orderFactory;
    protected $helperData;
    protected $_logo;
    protected $storeManager;
    const BASE_BANNER_PATH = "checkoutsubscriber/logo";
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = [],
        \Progos\Checkoutsubscriber\Helper\Data $helperData
    ) {
        parent::__construct($context, $registry, $data);
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->_orderFactory = $orderFactory;
        $this->helperData = $helperData;
        $this->_logo = $logo;
        $this->storeManager = $storeManager;
    }

    public function getOrder()
    {
        return  $this->_order = $this->_orderFactory->create()->loadByIncrementId(
            $this->checkoutSession->getLastRealOrderId());
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomer()->getId();
    }

    public function getHelper(){
        return $this->helperData;
    }

    public function getAjaxUrl(){
        return $this->getUrl('checkoutsubscriber/index/index');
    }

    public function getPopupBanner(){
        $banner = $this->getHelper()->getGeneralConfig("popup_banner");
        if ( ! empty($banner)) {
            return rtrim($this->getMediaUrl(), '/') . '/' . static::BASE_BANNER_PATH . '/' . $banner;
        }else{
            return $this->_logo->getLogoSrc();
        }
    }

    public function getMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}