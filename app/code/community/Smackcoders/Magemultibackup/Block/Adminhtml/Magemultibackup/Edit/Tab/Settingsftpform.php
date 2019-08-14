<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tab_Settingsftpform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
	$this->setTemplate('magemultibackup/ftpform.phtml');
        return parent::_prepareForm();
    }

    public function getFormValues(){
	$collmodels = Mage::getModel('magemultibackup/magemultibackupsettings')->getCollection();
	$getVal = Mage::getModel('magemultibackup/magemultibackupsettings');
	$returnValue = array();
	foreach($collmodels as $model){
		$assignVariables = $getVal->load($model->getId());
		$chkLocalVariab = $assignVariables->getVariable();
		$returnValue[$chkLocalVariab] = $assignVariables->getValue();
	}
	return $returnValue;
    }
}

