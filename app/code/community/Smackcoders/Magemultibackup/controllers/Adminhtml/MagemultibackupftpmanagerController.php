<?php
 
class Smackcoders_Magemultibackup_Adminhtml_MagemultibackupftpmanagerController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('magemultibackup/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
           $this->_title($this->__("FTP Manager"));

        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
	$this->getLayout()->getBlock('left')
           ->append($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_ftpactivetabs'));
	$this->_addContent($this->getLayout()->createBlock('magemultibackup/adminhtml_dialogs', 'magemultibackup'));//added for rollback backup
        $this->renderLayout();
    }
 
    public function deleteAction()
    {
	$postData = $this->getRequest()->getPost();
	$deleteData = $postData['massaction'];
        $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
	$collmodels = Mage::getModel('magemultibackup/magemultibackupsettings')->getCollection();
	$getVal = Mage::getModel('magemultibackup/magemultibackupsettings');
	$ftpdetails = Mage::getModel('magemultibackup/magemultibackup')->getFtpDetails();
	$conn_id = ftp_connect($ftpdetails['ftpserver'],$ftpdetails['ftpport']);
	$login_result = ftp_login($conn_id, $ftpdetails['ftpuser'], $ftpdetails['ftppassword']);
	foreach($deleteData as $modId){
	$ftpfiledeleted = 0;	
	$error = 'Check FTP Connection';
        $deleteFtpBackup=$magemultibackupModel->load($modId);
	$file = $deleteFtpBackup->getFtppath();
	$ftpfilename = $deleteFtpBackup->getFilename();
	if (ftp_delete($conn_id, $file)) {
		 $deleteFtpBackup->setDeletedat(time())
                ->setFtpfiledeleted(1)
                ->save();
	$ftpfiledeleted = 1;
	$error ='Success';
	}
	if($error == 'Success')
		$error = "Backupfile Deleted Successfully";
                $magemultibackupModel1 = Mage::getModel('magemultibackup/magemultibackup');
                $magemultibackupModel1->setCreatedat(time())
                    ->setFtpied(1)
                    ->setFtppath($file)
                    ->setError($error) //add this
                    ->setFtpfiledeleted($ftpfiledeleted)
                    ->setFilename($ftpfilename)
                    ->setCreated_time(time())
                    ->setAction(0)
                    ->setMode(1)
                    ->save();
	}
if($error == 'Backupfile Deleted Successfully')
 Mage::getSingleton('adminhtml/session')->addSuccess("Selected backup files are deleted successfully");
else
Mage::getSingleton('adminhtml/session')->addError("Check FTP Configuration");

     $this->_redirect('*/*/');
    }
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackupftpmanager_grid')->toHtml()
        );
    }
}
