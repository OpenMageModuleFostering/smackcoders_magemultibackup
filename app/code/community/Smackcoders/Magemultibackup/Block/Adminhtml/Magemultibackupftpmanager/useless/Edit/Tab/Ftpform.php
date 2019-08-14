<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tab_Ftpform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
	$magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
	$totalCollection = $magemultibackupModel->getCollection();
	$ftpied = $totalCollection->addFieldToFilter('ftpfiledeleted',0);
//$ftpied = $ftpied1->addFeildToFilter('deletedat', array('null'=>true));
//print '<pre>';
$values = array();
$i = 0;
foreach($ftpied as $ftp)
{
$del = $magemultibackupModel->load($ftp->getId());
$createdat = $del->getFilename();
$id = $del->getId();
$values[$i]['label'] = $createdat;
$values[$i]['value']= $id;
$i++;
}


        $fieldset = $form->addFieldset('magemultibackup_form', array('legend'=>Mage::helper('magemultibackup')->__('FTP Backups')));
 $fieldset->addField('ftpbackups', 'multiselect', array(
            'name'      => 'ftpbackups[]',
            'label'     => Mage::helper('cms')->__('Select Backups'),
            'title'     => Mage::helper('cms')->__('Select Backups'),
//            'required'  => true,
            'values'    => $values,
        ));
       
/*        $fieldset->addField('title', 'text', array(
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
        ));*/
       
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
