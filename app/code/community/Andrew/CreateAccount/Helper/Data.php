<?php
/**
 * Helper
 *
 * @category    Magento
 * @package     Andrew_CreateAccount
 * @author      Andrew  <andrew.izotov@yahoo.com>
 */
class Andrew_CreateAccount_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Checking if an account exists
     *
     * @param   Mage_Sales_Model_Order $order
     * @return  bool
     */
    public function isAccountExist(Mage_Sales_Model_Order $order)
    {
       return ($order->getCustomerId())?true:false;
    }

    /**
     * Send email ?
     *
     * @return  bool
     */
    public function doSendEmail()
    {
       return (bool)$this->_getRequest()->getParam('send_email');
    }

    /**
     * Do reassign other orders?
     *
     * @return  bool
     */
    public function doReassignOtherOrders()
    {
        return (bool)$this->_getRequest()->getParam('reassign_other_orders');
    }
}
