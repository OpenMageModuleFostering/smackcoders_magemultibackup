<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('magemultibackup_form', array('legend'=>Mage::helper('magemultibackup')->__('Item information')));
       
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('magemultibackup')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
 
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('magemultibackup')->__('Active'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('magemultibackup')->__('Inactive'),
                ),
            ),
        ));
       
        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('magemultibackup')->__('Content'),
            'title'     => Mage::helper('magemultibackup')->__('Content'),
            'style'     => 'width:98%; height:400px;',
            'wysiwyg'   => false,
            'required'  => true,
        ));
       
        if ( Mage::getSingleton('adminhtml/session')->getMagemultibackupData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMagemultibackupData());
            Mage::getSingleton('adminhtml/session')->setMagemultibackupData(null);
        } elseif ( Mage::registry('magemultibackup_data') ) {
            $form->setValues(Mage::registry('magemultibackup_data')->getData());
        }
        return parent::_prepareForm();
    }
}
