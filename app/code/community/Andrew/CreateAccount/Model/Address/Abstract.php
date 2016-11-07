<?php
/**
 * Base model
 *
 * @category    Andrew
 * @package     Andrew_CreateAccount
 * @author      Andrew  <andrew.izotov@yahoo.com>
 */
abstract class Andrew_CreateAccount_Model_Address_Abstract extends Varien_Object
{
    /**
     * Settings Save address in address boock
     */
    const SAVE_IN_ADDRESS_BOOK = 1;

    /**
     * Settings Use by default address
     */
    const USE_BY_DEFAULT = 1;

    /**
     * Object address
     *
     * @var Mage_Customer_Model_Address
     */
    protected $_address = null;

    /**
     * Object address
     *
     * @var Array
     */
    protected $_dataAddress = null;

    /**
     * Populate address data array
     *
     * @param  Mage_Customer_Model_Customer          $customer
     * @param  Mage_Sales_Model_Order_Address        $address
     * @return Andrew_CreateAccount_Model_Abstract   $this
     */
    protected function _setAddressToCustomer($customer, Mage_Sales_Model_Order_Address $address)
    {
       $this->setCustomer($customer);

       $this->_dataAddress = array (
            'firstname'  => $address->getFirstname(),
            'lastname'   => $address->getLastname(),
            'region_id'  => $address->getRegionId(),
            'street'     => $address->getStreet(),
            'city'       => $address->getCity(),
            'company'    => $address->getCompany(),
            'postcode'   => $address->getPostcode(),
            'country_id' => $address->getCountryId(),
            'telephone'  => $address->getTelephone()
       );

       return $this;
    }

    /**
     * Populate address entity
     *
     * @param  Mage_Customer_Model_Customer          $customer
     * @param  Mage_Sales_Model_Order                $order
     * @return Mage_Customer_Model_Address           $this
     */
    abstract public function populateAddress(Mage_Customer_Model_Customer $customer, Mage_Sales_Model_Order $order);

}