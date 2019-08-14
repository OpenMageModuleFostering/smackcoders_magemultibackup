<?php
class Smackcoders_Magemultibackup_Adminhtml_MagemultibackupbackendController extends Mage_Adminhtml_Controller_Action
{
  public function indexAction(){
           $this->loadLayout()->_setActiveMenu('magemultibackup/items');
	   $this->_title($this->__("DB Backup"));
	   $this->renderLayout();
    }
public static function getMagemultibackupModelObj(){
        static $obj = null;
        if ($obj === null) {
           $obj = Mage::getModel('magemultibackup/magemultibackup');
        }
        return $obj;
    }
public function scheduleBackup($type,$backupId){
$setSchedule = Mage::getModel('magemultibackup/magemultibackupscheduler');
                $setSchedule->setScheduletype ($type)
                    ->setMagemultibackupid($backupId)
                    ->setStatus('Scheduled')
                    ->save();

}
 public function localbackupAction(){
        $error= $this->getMagemultibackupModelObj()->chkLocalPath();
	$creationtime = time();
        $file = $this->getMagemultibackupModelObj()->getLocalPath().'/'.$creationtime.'_db_smartbackup.gz';// local file name or full path
	$mode = 2;
	if(!$error)
		$errorstatus = "Backup Scheduled";
	else{
		$errorstatus = $error;
		$mode = 0;
 	}
        $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
	$magemultibackupModel->setCreatedat($creationtime)
                       ->setFtpied(0)
                       ->setLocalpath($file)
                       ->setError($errorstatus)
                       ->setFilename($creationtime.'_db_smartbackup.gz')
                       ->setLocalfiledeleted(0)
                       ->setCreated_time(time())
                       ->setAction(1)
                       ->setStatus($mode)
                       ->setMode(1)
                       ->save();
	if(!$error){
		$this->scheduleBackup('localbackup',$magemultibackupModel->getId());
       		Mage::getSingleton('adminhtml/session')->addSuccess('Smart Backup is scheduled to process in background. You can check the status in Reports after sometime.');
	}
	$this->_redirect('*/adminhtml_magemultibackupmanager');
  }

   public function ftpbackupAction(){
        $error= $this->getMagemultibackupModelObj()->chkLocalPath();
        $creationtime = time();
        $mode = 2;
        if(!$error)
                $errorstatus = "FTP Backup Scheduled";
        else{
                $errorstatus = $error;
		$mode = 0;
	}
        $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
        $magemultibackupModel->setCreatedat($creationtime)
                       ->setFtpied(0)
                       ->setError($errorstatus)
                       ->setFilename($creationtime.'_db_smartbackup.gz')
                       ->setFtpfiledeleted(0)
                       ->setCreated_time(time())
                       ->setStatus($mode)
                       ->setAction(1)
                       ->setMode(1)
                       ->save();
        if(!$error){
                $this->scheduleBackup('localbackupforftp',$magemultibackupModel->getId());
                $this->scheduleBackup('movefileftp',$magemultibackupModel->getId());
                Mage::getSingleton('adminhtml/session')->addSuccess('Smart Backup is scheduled to process in background. You can check the status in Reports after sometime.');
        }
        $this->_redirect('*/adminhtml_magemultibackupftpmanager');
  }

   public function rollbackAction(){
	$filename = $this->getRequest()->getParam('time');
	$type = $this->getRequest()->getParam('type');
	$maintainance_mode = $this->getRequest()->getParam('maintenance_mode');
        $response = new Varien_Object();
	try {
        $passwordValid = Mage::getModel('backup/backup')->validateUserPassword(
                $this->getRequest()->getParam('password')
            );
        if (!$passwordValid) {
                $response->setError(Mage::helper('backup')->__('Invalid Password.'));
                return $this->getResponse()->setBody($response->toJson());
        }
        $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
	if($type == 'local'){
	$errorstatus = "Local rollback scheduled";
	$ftpied = 0;
	}
	elseif($type == 'ftp'){
        $errorstatus = "FTP rollback scheduled";
        $ftpied = 1;
        }
	if($maintainance_mode)
	$type = $type.'mm';
        $magemultibackupModel->setCreatedat(time())
                       ->setFtpied($ftpied)
                       ->setError($errorstatus)
                       ->setFilename($filename)
                       ->setFtpfiledeleted(0)
                       ->setCreated_time(time())
                       ->setStatus(2)
                       ->setAction(2)
                       ->setMode(1)
                       ->save();
	if($type == 'ftp')
       		 $this->scheduleBackup("getftpfileforrollback",$magemultibackupModel->getId());

                $this->scheduleBackup($type."rollback",$magemultibackupModel->getId());

	} catch (Mage_Backup_Exception_CantLoadSnapshot $e) {

        	    $errorMsg = Mage::helper('backup')->__('Backup file not found');
        } catch (Mage_Backup_Exception_FtpConnectionFailed $e) {
	            $errorMsg = Mage::helper('backup')->__('Failed to connect to FTP');
        } catch (Mage_Backup_Exception_FtpValidationFailed $e) {
        	    $errorMsg = Mage::helper('backup')->__('Failed to validate FTP');
        } catch (Mage_Backup_Exception_NotEnoughPermissions $e) {
        	    $errorMsg = Mage::helper('backup')->__('Not enough permissions to perform rollback');
        } catch (Exception $e) {
	            $errorMsg = Mage::helper('backup')->__('Failed to rollback');
        }
        if (!empty($errorMsg)) {
            $response->setError($errorMsg);
        }
	$response->setRedirectUrl("Rollback has been scheduled to process. Please come back after some time.");
        $this->getResponse()->setBody($response->toJson());

   }
}
