<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('magemultibackup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magemultibackup')->__('News Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('magemultibackup')->__('Item Information'),
            'title'     => Mage::helper('magemultibackup')->__('Item Information'),
            'content'   => $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}
