<?php
/**
 * Andrew_CreateAccount
 *
 * @category    Magento
 * @package     Andrew_CreateAccount
 * @license     <andrew.izotov@yahoo.com>
 */

class Andrew_CreateAccount_Block_Adminhtml_Account_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'andrew_createaccount';
        $this->_controller = 'adminhtml_account';
        $this->removeButton('reset');
    }

    public function getHeaderText()
    {
        return Mage::helper('andrew_createaccount')->__('Customer Account Information');
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/sales_order/');
    }
}