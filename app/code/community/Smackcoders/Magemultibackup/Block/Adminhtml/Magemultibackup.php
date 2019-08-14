<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_magemultibackup';
        $this->_blockGroup = 'magemultibackup';
        $this->_headerText = Mage::helper('magemultibackup')->__('Database Backup Reports');
        parent::__construct();
	$this->_removeButton('add');
    }
}
