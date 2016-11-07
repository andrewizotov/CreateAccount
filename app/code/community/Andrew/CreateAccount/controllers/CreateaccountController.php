<?php

/**
 * Adminhtml controller
 *
 * @category    Magento
 * @package     Andrew_CreateAccount
 * @author      <andrew.izotov@yahoo.com>
 */
class Andrew_CreateAccount_CreateaccountController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Current Order
     *
     * @var Mage_Sales_Model_Order
     */
    protected $_order = null;

    /**
     * General customer group
     */
    const CUSTOMER_GROUP_GENERAL = 'General';

    /**
     * helper
     * @var Andrew_CreateAccount_Helper_Data
     */
    protected $_helper = null;

    public function preDispatch()
    {
        parent::preDispatch();
        $this->setOrderById();
        $this->loadLayout()->_setActiveMenu('sales/order');
        $this->_helper = Mage::helper('andrew_createaccount');
        return $this;
    }

    protected function setOrderById()
    {
       if (null !== $this->getRequest()->getParam('order_id')) {
           $this->_order = Mage::getModel('sales/order')
               ->load($this->getRequest()->getParam('order_id'));
       }
       return $this;
    }

    public function indexAction()
    {
        if (null !== $this->_order) {
            $customer = Mage::getModel('customer/customer')->load($this->_order->getCustomerId());
            if (0 !== (int)$customer->getEntityId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('Customer account already exists'));
                Mage::log($this->__('Customer account already exists'));
                $this->_redirect('*/sales_order');
                return;
            }
            $customerData = Mage::getModel('andrew_createaccount/customer')
                ->persistentCustomerData($this->_order);
             Mage::register('customer_data', $customerData);
        }

        $this->_addContent(
            $this->getLayout()
                ->createBlock('andrew_createaccount/adminhtml_account_edit')
        );
        $this->renderLayout();
    }

    public function createAction()
    {
        try{
            $this->_customer = Mage::getModel("andrew_createaccount/customer")
                ->populateCustomer($this->getRequest(), $this->_order)
                ->save();

            Mage::getModel("andrew_createaccount/billing")
                ->populateAddress($this->_customer, $this->_order)
                ->save();

            Mage::getModel("andrew_createaccount/shipping")
                ->populateAddress($this->_customer, $this->_order)
                ->save();

            /* Sending notification email to customer */
            if ($this->_helper->doSendEmail()) {
                $this->_customer->sendNewAccountEmail('registered', '', $this->_order->getSoreId());
            }

            $this->_saveOrderProcess($this->_order);

            /* Reassign Other orders except base order */
            if ($this->_helper->doReassignOtherOrders()) {
                $this->_reassignOtherOrders();
            }
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__($e->getMessage()));
            Mage::log($e->getMessage());
            $this->_redirect('*/createaccount/index', array('order_id'=>$this->_order->getId()));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addSuccess(
            $this->__(sprintf("Customer account was created successfully Email: %s Password: %s",
                $this->_customer->getEmail(),
                $this->_customer->getPassword())
            )
        );

        Mage::log(
            $this->__(sprintf("Customer account was created successfully Email: %s Password: %s",
            $this->_customer->getEmail(),
            $this->_customer->getPassword()))
        );

        $this->_redirect('*/customer/edit/',array('id'=>$this->_customer->getId()));
    }

    /**
     * Reassign other guest orders except base order
     *
     * @return bool
     */
    protected function _reassignOtherOrders()
    {
        $orderCollection = Mage::getModel('sales/order')->getCollection();
        $orderCollection->addFieldToFilter('customer_email', $this->_customer->getEmail());
        $orderCollection->addFieldToFilter('entity_id', array('neq' => array($this->_order->getId())));
        $orderCollection->load();
        foreach ($orderCollection as $order) {
            $order = Mage::getModel('sales/order')->load($order['entity_id']);
            if ($order->getId()) {
                $this->_saveOrderProcess($order);
            }
        }

    }

    /**
     * Save order process
     *
     * @param  Mage_Sales_Model_Order $order
     * @return bool
     */
    protected function _saveOrderProcess($order)
    {
        $group = Mage::getModel('customer/group')->load(self::CUSTOMER_GROUP_GENERAL,'customer_group_code');
        $order->setCustomerId($this->_customer->getEntityId());
        $order->setCustomerIsGuest(0);
        $order->setCustomerGroupId($group->getCustomerGroupId());
        $order->save();
    }
}