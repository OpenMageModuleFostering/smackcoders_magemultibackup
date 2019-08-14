<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackupmanager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_magemultibackupmanager';
        $this->_blockGroup = 'magemultibackup';
        $this->_headerText = Mage::helper('magemultibackup')->__('Local Server Backups');
        $this->_addButtonLabel = Mage::helper('magemultibackup')->__('Backup');
        $this->_addButton('backup', array(
            'label'     => Mage::helper('Backup')->__('Do Smart Backup'),
            'onclick'   => "setLocation('".$this->getUrl('*/adminhtml_magemultibackupbackend/localbackup')."')",
         ));
        parent::__construct();
	$this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
//        $this->setChild('dialogs', $this->getLayout()->createBlock('magemultibackup/adminhtml_dialogs'));
	}
    public function getDialogsHtml()
    {
        return $this->getChildHtml('dialogs');
    }

}
