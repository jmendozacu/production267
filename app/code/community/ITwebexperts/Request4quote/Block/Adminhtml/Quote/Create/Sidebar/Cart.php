<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order create sidebar cart block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class ITwebexperts_Request4quote_Block_Adminhtml_Quote_Create_Sidebar_Cart
    extends ITwebexperts_Request4quote_Block_Adminhtml_Quote_Create_Sidebar_Abstract
{
    /**
     * Storage action on selected item
     *
     * @var string
     */
    protected $_sidebarStorageAction = 'add_cart_item';

    protected function _construct()
    {
        parent::_construct();
        $this->setId('sales_order_create_sidebar_cart');
        $this->setDataId('cart');
    }

    public function getHeaderText()
    {
        return Mage::helper('request4quote')->__('Shopping Cart');
    }

    /**
     * Retrieve item collection
     *
     * @return mixed
     */
    public function getItemCollection()
    {
        $collection = $this->getData('item_collection');
        if (is_null($collection)) {
            $collection = $this->getCreateOrderModel()->getCustomerCart()->getAllVisibleItems();
            $this->setData('item_collection', $collection);
        }
        return $collection;
    }

    public function canDisplayItemQty()
    {
        return true;
    }

    /**
     * Retrieve identifier of block item
     *
     * @param Varien_Object $item
     * @return int
     */
    public function getIdentifierId($item)
    {
        return $item->getId();
    }

    /**
     * Retrieve product identifier linked with item
     *
     * @param   Mage_Sales_Model_Quote_Item $item
     * @return  int
     */
    public function getProductId($item)
    {
        return $item->getProduct()->getId();
    }

    /**
     * Prepare layout
     *
     * Add button that clears customer's shopping cart
     *
     * @return Mage_Adminhtml_Block_Sales_Order_Create_Sidebar_Cart
     */
    protected function _prepareLayout()
    {
        $deleteAllConfirmString = Mage::helper('request4quote')->__('Are you sure you want to delete all items from shopping cart?');
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label' => Mage::helper('request4quote')->__('Clear Shopping Cart'),
            'onclick' => 'order.clearShoppingCart(\'' . $deleteAllConfirmString . '\')',
            'style' => 'float: right;'
        ));
        $this->setChild('empty_customer_cart_button', $button);

        return parent::_prepareLayout();
    }
}
