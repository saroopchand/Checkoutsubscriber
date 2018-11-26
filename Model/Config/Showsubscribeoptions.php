<?php
namespace Progos\Checkoutsubscriber\Model\Config;

class Showsubscribeoptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => "no", 'label' => __('No')],
            ['value' => "popup", 'label' => __('Popup')],
            ['value' => "page", 'label' => __('Page')]
        ];
    }
}