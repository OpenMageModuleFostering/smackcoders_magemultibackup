<?php 
class Smackcoders_Magemultibackup_Model_Autoschedule
{
    public function scheduledBackup(){
	$this->chkAutoschedule();
	$collection = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('status',array('eq' => 'Initiated'));
	ini_set('max_execution_time', 0);
	ini_set('memory_limit','128M');
	if(count($collection) == 0){
	$scheduledCollection = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('status',array('eq'=>'Scheduled'));
	foreach($scheduledCollection as $schedule){
		$type = $schedule->getScheduletype();
                $estimatedtime = $this->getEstimatedTime($type);
		if($type == 'localbackup'){
   		        $schedule->setStatus('Initiated')->setStarttime(time())->save();
			$this->localBackup($schedule->getId());
                        if(!$estimatedtime)
                        $estimatedtime = time() - $schedule->getStarttime();
                        $schedule->setActualtime(time())->setStatus('Completed')->setEstimatedtime($estimatedtime)->save();
		}
		elseif($type == 'localbackupforftp'){
                        $schedule->setStatus('Initiated')->setStarttime(time())->save();
			$magemultibackupcoll = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('magemultibackup_id',array('eq'=>$schedule->getMagemultibackupid()));	
			foreach($magemultibackupcoll as $db)
			$this->takeBackup(strtotime($db->getCreatedat()),Mage::getModel('magemultibackup/magemultibackup')->getLocalPath());
                        if(!$estimatedtime)
                        $estimatedtime = time()- $schedule->getStarttime();
                        $schedule->setActualtime(time())->setStatus('Completed')->setEstimatedtime($estimatedtime)->save();
		}
		elseif($type == 'movefileftp'){
			$chkfileCreation = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('magemultibackupid',array('eq'=>$schedule->getMagemultibackupid()))->addFieldToFilter('scheduletype',array('eq'=>'localbackupforftp'));	
			foreach($chkfileCreation as $chkFileCreation)
			$chkfilestatus = $chkFileCreation->getStatus();
			if($chkfilestatus == 'Completed'){
                        $schedule->setStatus('Initiated')->setStarttime(time())->save();
			$this->uploadFileToFtp($schedule->getMagemultibackupid());
                       if(!$estimatedtime)
                        $estimatedtime = time()- $schedule->getStarttime();
                        $schedule->setActualtime(time())->setStatus('Completed')->setEstimatedtime($estimatedtime)->save();
			}
		}
		elseif(($type == 'localrollback')||($type == 'localmmrollback')){
	                $schedule->setStatus('Initiated')->setStarttime(time())->save();
			$chkFileExistscoll = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('magemultibackup_id',array('eq'=>$schedule->getMagemultibackupid()));
			foreach($chkFileExistscoll as $chkFileExists)
			$filename = $chkFileExists->getFilename();
			if(file_exists(Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath().'/'.$filename)){
				$splitfile = explode("_",$filename);
				$timestamp = $splitfile[0];
				$this->rollBack($timestamp);

			}
                       if(!$estimatedtime)
                        $estimatedtime = time()- $schedule->getStarttime();
                        $schedule->setActualtime(time())->setStatus('Completed')->setEstimatedtime($estimatedtime)->save();
		}
		elseif($type == 'getftpfileforrollback'){
		$schedule->setStatus('Initiated')->setStarttime(time())->save();
                $chkFileExists = Mage::getModel('magemultibackup/magemultibackup')->load($schedule->getMagemultibackupid());
                $filename = Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath().'/'.$chkFileExists->getFilename();
                $downloaded = $this->downloadFile($chkFileExists->getFilename());
                $schedule->setActualtime(time())->setStatus('Completed')->setEstimatedtime($estimatedtime)->save();
		}
		elseif(($type == 'ftprollback')||($type == 'ftpmmrollback')){
 		$chkfileDownloaded = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('magemultibackupid',array('eq'=>$schedule->getMagemultibackupid()))->addFieldToFilter('scheduletype',array('eq'=>'getftpfileforrollback'));
                        foreach($chkfileDownloaded as $downloaded)
                        $chkfilestatus = $downloaded->getStatus();
                        if($chkfilestatus == 'Completed'){
		$schedule->setStatus('Initiated')->setStarttime(time())->save();
                $chkFileExists = Mage::getModel('magemultibackup/magemultibackup')->load($schedule->getMagemultibackupid());
                $filename = Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath().'/'.$chkFileExists->getFilename();
			if(file_exists($filename)){
				$splitfile = explode("_",$chkFileExists->getFilename());
				$timestamp = $splitfile[0];
				$this->rollBack($timestamp);
			}
		   }
                       if(!$estimatedtime)
                        $estimatedtime = time()- $schedule->getStarttime();
                        $schedule->setActualtime(time())->setStatus('Completed')->setEstimatedtime($estimatedtime)->save();
		}
	    }
   	}
	else{
	foreach($collection as $coll){
		$initiatedId = $coll->getId();
		$magemultibackupId = $coll->getMagemultibackupid();
		$type = $coll->getScheduletype();
		$starttime = $coll->getStarttime();
		if(($starttime+10800) > (time())){
		$coll->setStatus('Incomplete')->setActualtime(time())->save();
		$reportUpdate = Mage::getSingleton('magemultibackup/magemultibackup')->load($coll->getMagemultibackupid());
		$reportUpdate->setStatus(0)->setError("Failed due to segmentation fault")->save();
		}

	     }
	}
	exit;
  }
	public function chkAutoschedule(){
                $ftpdetails = Mage::getSingleton('magemultibackup/magemultibackup')->getFtpDetails();
                $getMagentoTime = strtotime(date("H:i:s", Mage::getModel('core/date')->timestamp(time())));
                $stringDate = strtotime(date("Y-m-d",Mage::getModel('core/date')->timestamp(time())));
                $getMagentoDay = date("D", Mage::getModel('core/date')->timestamp(time()));
                $firstday = Mage::getStoreConfig('general/locale/firstday');
                if($firstday == 0)
                        $daytoexecute = 'Sat';
                else if ($firstday == 1)
                        $daytoexecute = 'Sun';
                else if($firstday == 2)
                        $daytoexecute = 'Mon';
                else if ($firstday == 3)
                        $daytoexecute = 'Tue';
                else if ($firstday == 4)
                        $daytoexecute = 'Wed';
                else if ($firstday == 5)
                        $daytoexecute = 'Thu';
                else if ($firstday == 6)
                        $daytoexecute = 'Fri';
                $stringLastdate = strtotime(date("Y-m-d",strtotime("+1 month -1 second",strtotime(date("Y-m-1", Mage::getModel('core/date')->timestamp(time()))))));
                if($ftpdetails['localscheduler']){

                        if((($ftpdetails['localschedulefrequency'] == 'W')&&($getMagentoDay == $daytoexecute))||($ftpdetails['localschedulefrequency'] == 'D')||(($ftpdetails['localschedulefrequency'] == 'M')&&($stringLastdate == $stringDate))){
                                $cronRuntime = str_replace(',',':',$ftpdetails['localscheduletime']);
                                $cronRuntime = strtotime($cronRuntime);
                                $diff = round(abs($cronRuntime - $getMagentoTime) / 60,2);
                                $diff = round($diff);
             			if($diff == 0)
                                	$this->autoLocalBackup();
                  	}
        	}
		if($ftpdetails['ftpscheduler']){
			if((($ftpdetails['ftpschedulefrequency'] == 'W')&&($getMagentoDay == $daytoexecute))||($ftpdetails['ftpschedulefrequency'] == 'D')||(($ftpdetails['ftpschedulefrequency'] == 'M')&&($stringLastdate == $stringDate))){
				$cronRuntime = str_replace(',',':',$ftpdetails['ftpscheduletime']);
                                $cronRuntime = strtotime($cronRuntime);
                                $diff = round(abs($cronRuntime - $getMagentoTime) / 60,2);
                                $diff = round($diff);
                                if($diff == 0)
                                        $this->autoFtpBackup();
			}
		}
		
}
  public function downloadFile($filename)
  {
	$ftpdetails = Mage::getSingleton('magemultibackup/magemultibackup')->getFtpDetails();
        require_once('FTP/FTPConnect.class.php');
        $ftp = new FTPConnect($ftpdetails['ftpserver'], $ftpdetails['ftpuser'], $ftpdetails['ftppassword'],$ftpdetails['ftpport']);
        $remote_file = $ftpdetails['ftppath'].'/'.$filename;
	$localpath = Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath();
        $res = $ftp->download_file($remote_file,$localpath.'/'.$filename);
	$error = $ftp->show_error();
	return $res;
  }
   public function rollBack($time){
	$localpath = Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath();
	try{
        $backupManager = Mage_Backup::getBackupInstance('db')
                        ->setBackupExtension('gz')
                        ->setTime($time)
                        ->setBackupsDir($localpath)
                        ->setName('smartbackup', false)
                        ->setResourceModel(Mage::getResourceModel('backup/db'));
        Mage::register('backup_manager', $backupManager);
	$backupManager->rollback();
	}
	catch(Exception $e){
	}
        $collection = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('status',array('eq' => 'Initiated'));
	foreach($collection as $mod){
		$mod->setStatus("Completed")->setActualtime(time())->save();
	}
   }
   public function uploadFileToFtp($magemultibackupId){
 	$magemultibackupcoll = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('magemultibackup_id',array('eq'=>$magemultibackupId));
	foreach($magemultibackupcoll as $dbbackModel)
	$filepath = Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath().'/'. $dbbackModel->getFilename();
	$ftpdetails = Mage::getSingleton('magemultibackup/magemultibackup')->getFtpDetails();
	 require_once('FTP/FTPConnect.class.php');
	$ftp = new FTPConnect($ftpdetails['ftpserver'], $ftpdetails['ftpuser'], $ftpdetails['ftppassword'],$ftpdetails['ftpport']);
        $res = $ftp->upload_file($filepath, $ftpdetails['ftppath'].'/'.$dbbackModel->getFilename());
	if($res){
	$fileId = Mage::getSingleton('magemultibackup/magemultibackup')->getFileId($filepath);
	$ftpmessage = "Backup completed successfully";
	}
	else{
	$ftpmessage = $ftp->show_error();
	$res = 0;
	}
	$dbbackModel->setFtpied(1)
                    ->setFtppath($ftpdetails['ftppath'].'/'.$dbbackModel->getFilename())
                    ->setError($ftpmessage)
                    ->setFtpfiledeleted(0)
                    ->setCreated_time(time())
                    ->setAction(1)
                    ->setStatus($res)
                    ->setFileid($fileId)
                    ->save();

}
public function takeBackup($creationtime,$backupabsolutepath){
		$backupManager = Mage_Backup::getBackupInstance("db")
				->setBackupExtension('gz')
                	        ->setTime($creationtime)
                        	->setBackupsDir($backupabsolutepath)
	       			->setName('smartbackup');
        	$backupManager->create();
}
public function localBackup($scheduleId){
	$scheduleModel = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('scheduler_id',array('eq'=>$scheduleId));
	foreach($scheduleModel as $schedule){
	$backupId = $schedule->getMagemultibackupid();
	}
	$magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('magemultibackup_id',array('eq' =>$backupId));
	foreach($magemultibackupModel as $magemultibackup){
		$creationtime = strtotime($magemultibackup->getCreatedat());
	}
	$backupabsolutepath = Mage::getModel('magemultibackup/magemultibackup')->getLocalPath();
	$error = Mage::getModel('magemultibackup/magemultibackup')->chkLocalPath();
	if(!$error){
		$starttime = time();
		$this->takeBackup($creationtime,$backupabsolutepath);
		$file = $backupabsolutepath.'/'.$creationtime.'_db_smartbackup.gz';
		$fileId = Mage::getModel('magemultibackup/magemultibackup')->getFileId($file);
        	$filename = $creationtime.'_db_smartbackup.gz';
                $magemultibackup->setFtpied(0)
                	->setLocalpath($file)
                        ->setError('Backup taken successfully')
                        ->setFilename($filename)
                        ->setLocalfiledeleted(0)
                        ->setCreated_time(time())
                        ->setAction(1)
                        ->setStatus(1)
                        ->setFileid($fileId)
                        ->save();
		}
	}
   public function getEstimatedTime($type){
        $modcoll = Mage::getModel('magemultibackup/magemultibackupscheduler')->getCollection()->addFieldToFilter('scheduletype',array('eq'=>$type));
        foreach($modcoll as $mod)
                $fmod = $mod;
        $estimatedtime = Mage::getModel('magemultibackup/magemultibackupscheduler')->load($fmod->getId())->getEstimatedtime();
        return $estimatedtime;
}
   public function autoFtpBackup(){
        $error = Mage::getSingleton('magemultibackup/magemultibackup')->chkLocalPath();
        $creationtime = time();
        if(!$error)
                $errorstatus = "FTP Backup Scheduled";
        else
                $errorstatus = $error;
        $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
        $magemultibackupModel->setCreatedat($creationtime)
                       ->setFtpied(0)
                       ->setError($errorstatus)
                       ->setFilename($creationtime.'_db_smartbackup.gz')
                       ->setFtpfiledeleted(0)
                       ->setCreated_time(time())
                       ->setStatus(0)
                       ->setAction(1)
                       ->setMode(0)
                       ->save();
        if(!$error){
                $this->scheduleBackup('localbackupforftp',$magemultibackupModel->getId());
                $this->scheduleBackup('movefileftp',$magemultibackupModel->getId());
        }
   }
   public function autoLocalBackup(){
	$error = Mage::getSingleton('magemultibackup/magemultibackup')->chkLocalPath();
	$creationtime = time();
        $file = Mage::getSingleton('magemultibackup/magemultibackup')->getLocalPath().'/'.$creationtime.'_db_smartbackup.gz';
        if(!$error)
                $errorstatus = "Backup Scheduled";
        else{
                $errorstatus = $error;
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
                       ->setStatus(0)
                       ->setMode(0)
                       ->save();
        if(!$error){
                $this->scheduleBackup('localbackup',$magemultibackupModel->getId());
        }
   }
   public function scheduleBackup($type,$backupId){
	$setSchedule = Mage::getModel('magemultibackup/magemultibackupscheduler');
                $setSchedule->setScheduletype ($type)
                    ->setMagemultibackupid($backupId)
                    ->setStatus('Scheduled')
                    ->save();

}


}

