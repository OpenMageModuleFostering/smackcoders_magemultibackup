<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tabs1 extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('magemultibackup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magemultibackup')->__('Backups'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('magemultibackup')->__('Local Backups'),
            'title'     => Mage::helper('magemultibackup')->__('Local Backups'),
            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_localform')->toHtml(),
        ));

	 $this->addTab('form_section1', array(
            'label'     => Mage::helper('magemultibackup')->__('FTP Backups'),
            'title'     => Mage::helper('magemultibackup')->__('FTP Backups'),
            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_ftpform')->toHtml(),
        ));

       
        return parent::_beforeToHtml();
    }
}
