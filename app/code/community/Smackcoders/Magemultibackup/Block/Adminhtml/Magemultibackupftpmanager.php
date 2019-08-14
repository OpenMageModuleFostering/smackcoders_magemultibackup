<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackupftpmanager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_magemultibackupftpmanager';
        $this->_blockGroup = 'magemultibackup';
        $this->_headerText = Mage::helper('magemultibackup')->__('FTP Backups');
//        $this->_addButtonLabel = Mage::helper('magemultibackup')->__('Add Item');
        $this->_addButton('ftpbackup', array(
            'label'     => Mage::helper('Backup')->__('Do Smart Backup'),
            'onclick'   => "setLocation('".$this->getUrl('*/adminhtml_magemultibackupbackend/ftpbackup')."')",
         ));
 
        parent::__construct();
$this->_removeButton('add');
    }
}
