<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Settingsedit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'magemultibackup';
        $this->_controller = 'adminhtml_magemultibackup';
	$this->_removeButton('delete');
    }
 
    public function getHeaderText()
    {
	return Mage::helper('magemultibackup')->__('Settings');
    }
}
