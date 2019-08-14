<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Settingstabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('magemultibackup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magemultibackup')->__('Settings'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('magemultibackup')->__('Manage Backup Options'),
            'title'     => Mage::helper('magemultibackup')->__('Manage Backup Options'),
//            'content'   =>$this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_settingslocalform')->toHtml().$this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_settingsftpform')->toHtml(),
            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_settingsftpform')->toHtml(),

        ));

	 $this->addTab('form_notifications', array(
            'label'     => Mage::helper('magemultibackup')->__('Email Notifications'),
            'title'     => Mage::helper('magemultibackup')->__('Notifications'),
            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_notificationsform')->toHtml(),
        ));
/* $this->addTab('form_scheduler', array(
            'label'     => Mage::helper('magemultibackup')->__('Scheduler'),
            'title'     => Mage::helper('magemultibackup')->__('Scheduler'),
            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_schedulerform')->toHtml(),
        ));*/


//echo'prem';      $this->getChildBlock('grid.massaction')->getJavaScript(); 
        return parent::_beforeToHtml();
    }
}
