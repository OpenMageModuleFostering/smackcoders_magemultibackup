<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tab_Localform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
	$magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
	$totalCollection = $magemultibackupModel->getCollection();
	$ftpied = $totalCollection->addFieldToFilter('localfiledeleted',0);
//$this->addFieldToFilter('parent_item_id', array('null' => true));
//print '<pre>';
	$values = array();
	$i = 0;
	foreach($ftpied as $ftp){
$del = $magemultibackupModel->load($ftp->getId());
$createdat = $del->getFilename();
$id = $del->getId();
$values[$i]['label'] = $createdat;
$values[$i]['value']= $id;
$i++;
}

        $fieldset = $form->addFieldset('magemultibackup_form', array('legend'=>Mage::helper('magemultibackup')->__('Local Backups')));
        $fieldset->addField('localbackups', 'multiselect', array(
            'name'      => 'localbackups[]',
            'label'     => Mage::helper('cms')->__('Select Backups'),
            'title'     => Mage::helper('cms')->__('Select Backups'),
//            'required'  => true,
            'values'    => $values,
        ));
/*for($j=0;$j<count($values);$j++)
{
$fieldset->addField("localbackup$j", 'checkbox', array(
            'name'      => 'localbackups[]',
            'value'    => $values[$j]['value'],
	    'label'     => $values[$j]['label'],
        ));
 }*/
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
