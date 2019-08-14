<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Settings_Edit1 extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
//        $this->_objectId = 'id';
        $this->_blockGroup = 'magemultibackup';
        $this->_controller = 'adminhtml_magemultibackup';
//        $this->_updateButton('save', 'label', Mage::helper('magemultibackup')->__('Delete'));
//        $this->_updateButton('delete', 'label', Mage::helper('magemultibackup')->__('Delete Item'));
$this->_removeButton('reset');
$this->_removeButton('back');
$this->_removeButton('delete');
$this->_removeButton('save');

    }
 
    public function getHeaderText()
    {
/*        if( Mage::registry('magemultibackup_data') && Mage::registry('magemultibackup_data')->getId() ) {
            return Mage::helper('magemultibackup')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('magemultibackup_data')->getTitle()));
        } else {
            return Mage::helper('magemultibackup')->__('Add Item');
        }*/
return Mage::helper('magemultibackup')->__('Backup Manager');
    }
}
