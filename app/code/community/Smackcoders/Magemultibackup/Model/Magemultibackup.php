<?php
 
class Smackcoders_Magemultibackup_Model_Magemultibackup extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('magemultibackup/magemultibackup');
    }

    public function loadForLocalRollback($filename,$type){
	$models = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('ftpied', array('eq' => 0))->addFieldToFilter('localfiledeleted', array('eq' => 0))->addFilter('filename',$filename);
	foreach ($models as $model){
		$ret = $model;
	}
	return $ret;
    }

   public function loadForFtpRollback($filename,$type){
	$models = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('ftpied', array('eq' => 1))->addFieldToFilter('ftpfiledeleted', array('eq' => 0))->addFilter('filename',$filename);
        foreach ($models as $model){
                $ret = $model;
        }
        return $ret;

   }
   public function getLocalPath(){
        $collmodels = Mage::getModel('magemultibackup/magemultibackupsettings')->getCollection();
        foreach($collmodels as $model){
        if($model->getVariable() == 'localpath')
                $localpath = $model->getValue();
        }
        return Mage::getBaseDir()."/$localpath";
   }
  public function chkLocalPath(){
     $localpath = $this->getLocalPath();
        if(is_dir($localpath)){
                if(is_writable($localpath)){
                       return false;
                }
                else{
                        $error = 'Given backup directory is not writtable in store server';
                        Mage::getSingleton('adminhtml/session')->addError($error);
                }

        }
        else{
                $error = 'Backup directory not found in store server.';
                Mage::getSingleton('adminhtml/session')->addError($error);
        }

    return $error;
}
  public function getFileId($file){
        $fileId = null;
        if(file_exists($file))
        $fileId = md5_file($file);
        return $fileId;
   }
   public function getFtpDetails(){
	$collmodels = Mage::getModel('magemultibackup/magemultibackupsettings')->getCollection();
	$ftp = array();
        $getVal = Mage::getModel('magemultibackup/magemultibackupsettings');
        foreach($collmodels as $model){
        	$assignVariables = $getVal->load($model->getId());
                $chkLocalVariab = $assignVariables->getVariable();
		$ftp[$assignVariables->getVariable()] = $assignVariables->getValue();
                }
	return $ftp;
	}
}
