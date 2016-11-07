<?php

/**
 * Adminhtml sales order view page
 *
 * @category    Mage
 * @package     Andrew_CreateAccount
 * @author      <andrew.izotov@yahoo.com>
 */
class Andrew_CreateAccount_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    /**
     * Show a button 'Create Account' if account doesn't exist
     *
     */
    public function __construct()
    {
        parent::__construct();

        if (!Mage::helper('andrew_createaccount')->isAccountExist($this->getOrder())) {
            $this->addButton('order_account_create', array(
                'label'   => Mage::helper('sales')->__('Create Account'),
                'onclick' => 'setLocation(\'' . $this->getCreateAccountUrl() . '\')',
                'class'   => 'go'
            ));
        }
    }

    public function getCreateAccountUrl()
    {
        return Mage::getModel('adminhtml/url')
            ->getUrl('*/createaccount/index',
                array('order_id'=>$this->getOrder()->getId())
            );
    }
}
