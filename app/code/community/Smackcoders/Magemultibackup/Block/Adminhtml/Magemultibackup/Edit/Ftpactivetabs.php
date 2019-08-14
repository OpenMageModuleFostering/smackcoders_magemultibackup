<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Ftpactivetabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('magemultibackup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magemultibackup')->__('Restore / Delete'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('magemultibackup')->__('Local Backups'),
            'title'     => Mage::helper('magemultibackup')->__('Local Backups'),
//            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackupmanager_grid')->toHtml(),
            'url'   => $this->getUrl('*/adminhtml_magemultibackupmanager/index',array('_current' => true)),
//            'class' => 'ajax',
        ));

	 $this->addTab('form_section1', array(
            'label'     => Mage::helper('magemultibackup')->__('FTP Backups'),
            'title'     => Mage::helper('magemultibackup')->__('FTP Backups'),
//            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_ftpform')->toHtml(),
            'url'   => $this->getUrl('*/adminhtml_magemultibackupftpmanager/index',array('_current' => true)),
  //          'class' => 'ajax',
	    'active' =>true,
        ));

//echo'prem';      $this->getChildBlock('grid.massaction')->getJavaScript(); 
        return parent::_beforeToHtml();
    }
}
