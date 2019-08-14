<?php 
class Smackcoders_Magemultibackup_Adminhtml_SettingsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
	$this->_forward('edit');
    }
    public function editAction() {
	 $this->loadLayout();
         $this->_setActiveMenu('magemultibackup/items');
	 $this->_title($this->__("DB Backup Delete"));
	 $this->_addContent($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_settingsedit'))
                 ->_addLeft($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_settingstabs'));
         $this->renderLayout();

    }
    public function getTime($time){
	for($i=0;$i<3;$i++){
	if($i==0)
	$returntime = $time[0];
	else
	$returntime .= ','.$time[$i];
	}
    return $returntime;
    }

    public function saveAction(){
        $postData = $this->getRequest()->getPost();
	if(isset($postData['localscheduletime']))
	$localscheduletime = $this->getTime($postData['localscheduletime']);
	if(isset($postData['ftpscheduletime']))
	$ftpscheduletime = $this->getTime($postData['ftpscheduletime']);
	$model = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateLocalVariable = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateLocalPath =  Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateFtp = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateFtpserver = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateFtpuser = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateFtppassword = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateFtppath = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateFtpport = Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateLocalscheduler = Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateLocalschedulemonth = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateLocalscheduletime =  Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpscheduler =  Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpscheduletime =  Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpscheduleday =  Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpschedulemonth =  Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpscheduletime =  Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpscheduleday =  Mage::getModel('magemultibackup/magemultibackupsettings');
//      $updateftpschedulemonth =  Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateLocalschedulefrequency = Mage::getModel('magemultibackup/magemultibackupsettings');
        $updateFtpschedulefrequency = Mage::getModel('magemultibackup/magemultibackupsettings');
	$updateMaintenancehtml = Mage::getModel('magemultibackup/magemultibackupsettings');


	$collections = $model->getCollection();
	foreach($collections as $collection){
		$chkLocal = $model->load($collection->getId());
		$chkLocalVariab = $chkLocal->getVariable();
		if ($chkLocalVariab=='local'){
		$updateLocalVariable = $chkLocal;
		$chkLocal->setVariable('local');
		$chkLocal->setValue($postData['local']);
		$chkLocal->save();
		$localSaved = 1;
		}
		if($chkLocalVariab == 'localpath'){
		$updateLocalPath = $chkLocal;
		$chkLocal->setVariable('localpath');
                $chkLocal->setValue($postData['localpath']);
                $chkLocal->save();
                $localpathSaved = 1;
		}
                if($chkLocalVariab == 'localscheduler'){
                $updateLocalscheduler = $chkLocal;
                $chkLocal->setVariable('localscheduler');
                $chkLocal->setValue($postData['localscheduler']);
                $chkLocal->save();
                $localschedulerSaved = 1;
                }
	        if($chkLocalVariab == 'localscheduletime'){
                $updateLocalscheduletime = $chkLocal;
                $chkLocal->setVariable('localscheduletime');
                $chkLocal->setValue($localscheduletime);
                $chkLocal->save();
                $localscheduletimeSaved = 1;
                }
                if($chkLocalVariab == 'localschedulemonth'){
                $updateLocalschedulemonth = $chkLocal;
                $chkLocal->setVariable('localschedulemonth');
                $chkLocal->setValue($postData['localschedulemonth']);
                $chkLocal->save();
                $localschedulemonthSaved = 1;
                }
                if($chkLocalVariab == 'localschedulefrequency'){
                $updateLocalschedulefrequency = $chkLocal;
                $chkLocal->setVariable('localschedulefrequency');
                $chkLocal->setValue($postData['localschedulefrequency']);
                $chkLocal->save();
                $localschedulefrequencySaved = 1;
                }

		if($chkLocalVariab == 'ftp'){
//                $updateLocalPath = $chkLocal;
                $chkLocal->setVariable('ftp');
                $chkLocal->setValue($postData['ftp']);
                $chkLocal->save();
		$ftpSaved = 1;
		$updateFtp = $chkLocal;
		}
		if($chkLocalVariab == 'ftpserver'){
		 $chkLocal->setVariable('ftpserver');
                $chkLocal->setValue($postData['ftpserver']);
                $chkLocal->save();
		$ftpserverSaved = 1;
		$updateFtpserver = $chkLocal;
		}
		if($chkLocalVariab == 'ftpuser'){
		$chkLocal->setVariable('ftpuser');
                $chkLocal->setValue($postData['ftpuser']);
                $chkLocal->save();
		$ftpuserSaved = 1;
		$updateFtpuser = $chkLocal;
		}
		if($chkLocalVariab == 'ftppassword'){
		$chkLocal->setVariable('ftppassword');
                $chkLocal->setValue($postData['ftppassword']);
                $chkLocal->save();
		$ftppasswordSaved = 1;
		$updateFtppassword = $chkLocal;
		}
		if($chkLocalVariab == 'ftppath'){
		$updateFtppath = $chkLocal;
		$chkLocal->setVariable('ftppath');
                $chkLocal->setValue($postData['ftppath']);
                $chkLocal->save();
		$ftppathSaved = 1;
		}
		if($chkLocalVariab == 'ftpport'){
		$updateFtpport = $chkLocal; 
		$chkLocal->setVariable('ftpport');
                $chkLocal->setValue($postData['ftpport']);
                $chkLocal->save();
		$ftpportSaved = 1;
		}
                if($chkLocalVariab == 'ftpscheduler'){
                $updateFtpscheduler = $chkLocal;
                $chkLocal->setVariable('ftpscheduler');
                $chkLocal->setValue($postData['ftpscheduler']);
                $chkLocal->save();
                $ftpschedulerSaved = 1;
                }
                if($chkLocalVariab == 'ftpscheduletime'){
                $updateFtpscheduletime = $chkLocal;
                $chkLocal->setVariable('ftpscheduletime');
                $chkLocal->setValue($ftpscheduletime);
                $chkLocal->save();
                $ftpscheduletimeSaved = 1;
                }
		if($chkLocalVariab == 'ftpscheduleday'){
                $updateFtpscheduleday = $chkLocal;
                $chkLocal->setVariable('ftpscheduleday');
                $chkLocal->setValue($postData['ftpscheduleday']);
                $chkLocal->save();
                $ftpscheduledaySaved = 1;
                }
                if($chkLocalVariab == 'ftpschedulemonth'){
                $updateFtpschedulemonth = $chkLocal;
                $chkLocal->setVariable('ftpschedulemonth');
                $chkLocal->setValue($postData['ftpschedulemonth']);
                $chkLocal->save();
                $ftpschedulemonthSaved = 1;
                }
		if($chkLocalVariab == 'ftpschedulefrequency'){
		$updateFtpschedulefrequency = $chkLocal;
		$chkLocal->setVariable('ftpschedulefrequency');
		$chkLocal->setValue($postData['ftpschedulefrequency']);
		$chkLocal->save();
		$ftpschedulefrequency = 1;
		}
		if($chkLocalVariab == 'maintenancehtml'){
		$updateMaintenancehtml = $chkLocal;
		$chkLocal->setVariable('maintenancehtml');
		$chkLocal->setValue($postData['maintenancehtml']);
		$chkLocal->save();
		$maintenancehtml = 1;
		}


	}
//for new save
	if(!$localSaved){
		$updateLocalVariable->setVariable('local');
		$updateLocalVariable->setValue($postData['local']);
		$updateLocalVariable->save();
	}
	if(($postData['localpath'])&&(!$localpathSaved)){
		$updateLocalPath->setVariable('localpath');
		$updateLocalPath->setValue($postData['localpath']);
		$updateLocalPath->save();
	}
	if(!$localschedulerSaved){
//	        $updateLocalscheduler = Mage::getModel('magemultibackup/magemultibackupsettings');
		$updateLocalscheduler->setVariable('localscheduler');
		$updateLocalscheduler->setValue($postData['localscheduler']);
		$updateLocalscheduler->save();
	}
        if((!$localscheduletimeSaved)&&($postData['localscheduletime'])){
//              $updateLocalschedulemonth = Mage::getModel('magemultibackup/magemultibackupsettings');
                $updateLocalscheduletime->setVariable('localscheduletime');
                $updateLocalscheduletime->setValue($localscheduletime);
                $updateLocalscheduletime->save();
        }
        if((!$localschedulefrequencySaved)&&($postData['localschedulefrequency'])){
//              $updateLocalschedulemonth = Mage::getModel('magemultibackup/magemultibackupsettings');
                $updateLocalschedulefrequency->setVariable('localschedulefrequency');
                $updateLocalschedulefrequency->setValue($localschedulefrequency);
                $updateLocalschedulefrequency->save();
        }


	if(!$ftpSaved){
		$updateFtp->setVariable('ftp');
		$updateFtp->setValue($postData['ftp']);
		$updateFtp->save();
	}
	if(($postData['ftpserver'])&&(!$ftpserverSaved)){
		$updateFtpserver->setVariable('ftpserver');
		$updateFtpserver->setValue($postData['ftpserver']);
		$updateFtpserver->save();
	}
	if(($postData['ftpuser'])&&(!$ftpuserSaved)){
		$updateFtpuser->setVariable('ftpuser');
		$updateFtpuser->setValue($postData['ftpuser']);
		$updateFtpuser->save();
	}
	if(($postData['ftppassword'])&&(!$ftppasswordSaved)){
		$updateFtppassword->setVariable('ftppassword');
		$updateFtppassword->setValue($postData['ftppassword']);
		$updateFtppassword->save();
	}
	if(($postData['ftppath'])&&(!$ftppathSaved)){
		$updateFtppath->setVariable('ftppath');
		$updateFtppath->setValue($postData['ftppath']);
		$updateFtppath->save();
	}	
	if(($postData['ftpport'])&&(!$ftpportSaved)){
		$updateFtpport->setVariable('ftpport');
		$updateFtpport->setValue($postData['ftpport']);
		$updateFtpport->save();
//		$ftpportSaved = 1;
	}
	if(($postData['ftpscheduler'])&&(!$ftpschedulerSaved)){
		$updateFtpscheduler->setVariable('ftpscheduler');
		$updateFtpscheduler->setValue($postData['ftpscheduler']);
		$updateFtpscheduler->save();
//		$ftpportSaved = 1;
	}
	if(($postData['ftpscheduletime'])&&(!$ftpscheduletimeSaved)){
		$updateFtpscheduletime->setVariable('ftpscheduletime');
		$updateFtpscheduletime->setValue($ftpscheduletime);
		$updateFtpscheduletime->save();
//		$ftpportSaved = 1;
	}
	if(($postData['ftpscheduleday'])&&(!$ftpscheduledaySaved)){
		$updateFtpscheduleday->setVariable('ftpscheduleday');
		$updateFtpscheduleday->setValue($postData['ftpscheduleday']);
		$updateFtpscheduleday->save();
//		$ftpportSaved = 1;
	}
        if(($postData['ftpschedulemonth'])&&(!$ftpschedulemonthSaved)){
                $updateFtpschedulemonth->setVariable('ftpschedulemonth');
                $updateFtpschedulemonth->setValue($postData['ftpschedulemonth']);
                $updateFtpschedulemonth->save();
//              $ftpportSaved = 1;
        }
	if(($postData['ftpschedulefrequency'])&&(!$ftpschedulefrequency)){
		$updateFtpschedulefrequency->setVariable('ftpschedulefrequency');
		$updateFtpschedulefrequency->setValue($postData['ftpschedulefrequency']);
		$updateFtpschedulefrequency->save();
	}
	if((!$maintenancehtml)&&($postData['maintenancehtml'])){
		$updateMaintenancehtml->setVariable('maintenancehtml');
		$updateMaintenancehtml->setValue($postData['maintenancehtml']);
		$updateMaintenancehtml->save();
	}

$this->chkLocalPath($postData['localpath']);
 	Mage::getSingleton('adminhtml/session')->addSuccess("Settings Saved");
	$this->_redirect('*/*/');
    }
public function chkLocalPath($localpath){
    $localpath = Mage::getBaseDir()."/$localpath";
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

}
 }//class ends
