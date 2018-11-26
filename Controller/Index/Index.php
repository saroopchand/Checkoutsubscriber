<?php

namespace Progos\Checkoutsubscriber\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Newsletter\Model\SubscriberFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    protected $request;
    protected $subscriberFactory;

    public function __construct(Context $context ,SubscriberFactory $subscriberFactory  , array $data = [])
    {
        $this->subscriberFactory = $subscriberFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->isPostRequest()) {
            throw new \Exception("Invalid request.");
        }
        $post = $this->getRequest()->getPostValue();
        $data = array();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try {
            if( !empty( $post['email'] ) )
                $this->subscriberFactory->create()->subscribe($post['email']);
            else
                throw new \Exception("Invalid request.");
            $data['msg'] = "Your Successfully Subscribed for Newsletter.";
            $data['status'] = true;
        }catch ( \Exception $e){
            $data['msg'] = $e->getMessage();
            $data['status'] = false;
        }
        $resultJson->setData($data);
        return $resultJson;
    }

    /**
     * @return bool
     */
    private function isPostRequest()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        return !empty($request->getPostValue());
    }
}
