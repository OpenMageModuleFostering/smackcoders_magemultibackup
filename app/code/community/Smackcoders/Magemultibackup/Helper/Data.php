<?php
class Smackcoders_Magemultibackup_Helper_Data extends Mage_Core_Helper_Abstract
{
  public function getHtmlCode() {
	$details = Mage::getSingleton('magemultibackup/magemultibackup')->getFtpDetails();
        return $details['maintenancehtml'];
    }
  public function shouldTurnOnMaintenance(){
	$collection = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('status',array('eq' => 'Initiated'))->addFieldToFilter('scheduletype',array('eq'=>'localmmrollback'));
	$collection1 = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('status',array('eq' => 'Initiated'))->addFieldToFilter('scheduletype',array('eq'=>'ftpmmrollback'));
	if((count($collection) > 0)||(count($collection1)>0))
	return true;
	else
	return false;
  }
}
	 
