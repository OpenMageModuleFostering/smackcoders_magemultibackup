<?php
 
class Smackcoders_Magemultibackup_Adminhtml_MagemultibackupController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('magemultibackup/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
           $this->_title($this->__("DB Backup Reports"));

        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->renderLayout();
    }
 
    public function exportCsvAction(){
        $fileName   = 'smartbackup_report.csv';
        $content    = $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
	}
   public function exportXmlAction(){
        $fileName   = 'smartbackup_report.xml';
        $content    = $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
	}
   protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream'){
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
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
                    ->setTitle($postData['title'])
                    ->setContent($postData['content'])
                    ->setStatus($postData['status'])
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
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $magemultibackupModel = Mage::getModel('magemultibackup/magemultibackup');
               
                $magemultibackupModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
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
               $this->getLayout()->createBlock('magemultibackup/adminhtml_magemultibackup_grid')->toHtml()
        );
    }
}
