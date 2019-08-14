<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'magemultibackup';
        $this->_controller = 'adminhtml_magemultibackup';
 
        $this->_updateButton('save', 'label', Mage::helper('magemultibackup')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('magemultibackup')->__('Delete Item'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('magemultibackup_data') && Mage::registry('magemultibackup_data')->getId() ) {
            return Mage::helper('magemultibackup')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('magemultibackup_data')->getTitle()));
        } else {
            return Mage::helper('magemultibackup')->__('Add Item');
        }
    }
}
