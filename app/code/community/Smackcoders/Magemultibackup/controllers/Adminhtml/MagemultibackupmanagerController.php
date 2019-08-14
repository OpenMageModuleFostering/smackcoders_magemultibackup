<?php
 
class Smackcoders_Magemultibackup_Adminhtml_MagemultibackupmanagerController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('magemultibackup/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
           $this->_title($this->__("Local Backup Manager"));

        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
	$this->getLayout()->getBlock('left')
           ->append($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tabs1'));
        $this->_addContent($this->getLayout()->createBlock('magemultibackup/adminhtml_dialogs', 'magemultibackup'));//added for backup
        $this->renderLayout();
    }
 
    public function editAction()
    {
        $magemultibackupId     = $this->getRequest()->getParam('id');
        $magemultibackupModel  = Mage::getModel('magemultibackup/magemultibackup')->load($magemultibackupId);
 
        if ($magemultibackupModel->getId() || $magemultibackupId == 0) {
 
            Mage::register('magemultibackup_data', $magemultibackupModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('magemultibackup/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit'))
                 ->_addLeft($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magemultibackup')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
    public function newAction()
    {
        $this->_forward('edit');
    }
   
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
               
                $magemultibackupModel->setId($this->getRequest()->getParam('id'))
//                    ->setTitle($postData['title'])
  //                  ->setContent($postData['content'])
    //                ->setStatus($postData['status'])
                    ->save();
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setMagemultibackupData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setMagemultibackupData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
   
    public function deleteAction()
    {
        $postData = $this->getRequest()->getPost();
        $deleteData = $postData['massaction'];
	$magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
        foreach($deleteData as $modid){
		$deleteLocalBackup=$magemultibackupModel->load($modid);
		$localfile = $deleteLocalBackup->getLocalpath();
		$filename = $deleteLocalBackup->getFilename();
		if(unlink($localfile.'/'.$filename)){
                	$deleteLocalBackup->setDeletedat(time())
                	->setLocalfiledeleted(1)
                	->save();
		$error = "Backupfile Deleted Successfully";
		Mage::getSingleton('adminhtml/session')->addSuccess("Selected backups files are deleted successfully");

		}
		else{

		$error = "Error occurred while deleting file";
		Mage::getSingleton('adminhtml/session')->addError("Error Occurred While deleting file");
		}
		  $magemultibackupModel1 = Mage::getModel('magemultibackup/magemultibackup');
                  $magemultibackupModel1->setCreatedat(time())
                    ->setFtpied(0)
                    ->setLocalpath($deleteLocalBackup->getLocalpath())
                    ->setError($error) //add this
                    ->setFtpfiledeleted(0)
                    ->setLocalfiledeleted(1)
                    ->setFilename($filename)
      //              ->setLocalfiledeleted(0)
                    ->setCreated_time(time())
                    ->setAction(0)
                    ->setMode(1)
                    ->save();

	}
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
               $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackupmanager_grid')->toHtml()
        );
// $this->_addContent($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackupmanager_grid'))
  //               ->_addLeft($this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_edit_tabs'));

    }
}
