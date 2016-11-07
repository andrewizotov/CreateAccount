<?php
/**
 * Shipping model
 *
 * @category    Andrew
 * @package     Andrew_CreateAccount
 * @author      Andrew  <andrew.izotov@yahoo.com>
 */
class Andrew_CreateAccount_Model_Shipping extends Andrew_CreateAccount_Model_Address_Abstract
{
    /**
     * Populate shipping address entity
     *
     * @param  Mage_Customer_Model_Customer     $customer
     * @param  Mage_Sales_Model_Order           $order
     * @return Mage_Customer_Model_Address      $this
     */
    public function populateAddress(Mage_Customer_Model_Customer $customer, Mage_Sales_Model_Order $order)
    {
        $this->_setAddressToCustomer($customer, $order->getShippingAddress());

        $this->_address  = Mage::getModel('customer/address');
        $this->_address->setData($this->_dataAddress)
            ->setCustomerId($this->getCustomer()->getId())
            ->setIsDefaultShipping(self::USE_BY_DEFAULT)
            ->setSaveInAddressBook(self::SAVE_IN_ADDRESS_BOOK);

        return $this->_address;
    }
}