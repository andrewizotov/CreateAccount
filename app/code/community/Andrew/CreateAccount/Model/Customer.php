<?php

class Andrew_CreateAccount_Model_Customer extends Varien_Object
{
   /**
    * Populate address entity
    *
    * @param  Mage_Core_Controller_Request_Http $request
    * @param  Mage_Sales_Model_Order $order
    * @return Mage_Customer_Model_Customer $customer
    */
   public function populateCustomer(Mage_Core_Controller_Request_Http $request, Mage_Sales_Model_Order $order)
   {
       $customer = Mage::getModel('customer/customer');
       $websiteId = Mage::app()->getWebsite()->getId();

       $customer->setWebsiteId($websiteId)
           ->setStore(Mage::getModel('core/store')->load($order->getStoreId()))
           ->setFirstname($request->getParam('firstname'))
           ->setLastname($request->getParam('lastname'))
           ->setEmail($request->getParam('email'))
           ->setTelephone($request->getParam('telephone'))
           ->setPassword($customer->generatePassword());

       return $customer;
   }

   /**
    * Persistent customer data
    *
    * @param  Mage_Sales_Model_Order $order
    * @return Andrew_CreateAccount_Model_Customer $customer
    */
   public function persistentCustomerData(Mage_Sales_Model_Order $order)
   {
       $billingAddress = $order->getBillingAddress();
       $this->setFirstname($billingAddress->getFirstname())
            ->setLastname($billingAddress->getLastname())
            ->setEmail($billingAddress->getEmail())
            ->setTelephone($billingAddress->getTelephone())
            ->setOrderId($order->getId());

       return $this;
   }
}