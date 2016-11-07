<?php

/**
 * Magento
 *
 * @category    Magento
 * @package     Andrew_CreateAccount
 */
class Andrew_CreateAccount_Block_Adminhtml_Account_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('customer_data');

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => Mage::getModel('adminhtml/url')->getUrl('*/createaccount/create',array('order_id'=>$model->getOrderId())),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('catalog')->__('Customer Information')));

        $yesno = array(
            array(
                'value' => 0,
                'label' => Mage::helper('andrew_createaccount')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('andrew_createaccount')->__('Yes')
            ));

        $fieldset->addField('firstname', 'text', array(
            'name'      => 'firstname',
            'label'     => Mage::helper('andrew_createaccount')->__('First Name'),
            'title'     => Mage::helper('andrew_createaccount')->__('First Name'),
            'required'  => true,
        ));

        $fieldset->addField('lastname', 'text', array(
            'name'      => 'lastname',
            'label'     => Mage::helper('andrew_createaccount')->__('Last Name'),
            'title'     => Mage::helper('andrew_createaccount')->__('Last Name'),
            'required'  => true,
        ));


        $fieldset->addField('email', 'text', array(
            'name'      => 'email',
            'label'     => Mage::helper('andrew_createaccount')->__('Email'),
            'title'     => Mage::helper('andrew_createaccount')->__('Email'),
            'required'  => true,
            'readonly' => true
        ));


        $fieldset->addField('telephone', 'text', array(
            'name'      => 'telephone',
            'label'     => Mage::helper('andrew_createaccount')->__('Telephone'),
            'title'     => Mage::helper('andrew_createaccount')->__('Telephone'),
            'required'  => true,
            'readonly' => true
        ));

        $fieldset->addField('send_email', 'select', array(
            'name'   => 'send_email',
            'label'  => Mage::helper('andrew_createaccount')->__('Notify customer by email ?'),
            'title'  => Mage::helper('andrew_createaccount')->__('Notify customer by email ?'),
            'values' => $yesno
        ));

        $fieldset->addField('order_id', 'hidden', array(
            'name'      => 'order_id',
            'label'     => Mage::helper('andrew_createaccount')->__('order id'),
        ));

        $fieldset->addField('reassign_other_orders', 'select', array(
             'name'   => 'reassign_other_orders',
             'label'  => Mage::helper('andrew_createaccount')->__('Reassign Other Guest Orders ?'),
             'title'  => Mage::helper('andrew_createaccount')->__('Reassign Other Guest Orders ?'),
             'values' => $yesno
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return $this;
    }
}
