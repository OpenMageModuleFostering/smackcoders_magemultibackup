<?php
class Smackcoders_Magemultibackup_Controller_Router_Standard extends Mage_Core_Controller_Varien_Router_Standard {

    public function match(Zend_Controller_Request_Http $request) {
	$helper = Mage::helper("magemultibackup");
	$maintenancePage= $helper->getHtmlCode();
	if($helper->shouldTurnOnMaintenance()){
	        Mage::getSingleton('core/session', array('name' => 'front'));
                $response = $this->getFront()->getResponse();
                $response->setHeader('HTTP/1.1', '503 Service Temporarily Unavailable');
                $response->setHeader('Status', '503 Service Temporarily Unavailable');
                $response->setHeader('Retry-After', '5000');
                $response->setBody($maintenancePage);
                $response->sendHeaders();
                $response->outputBody();
		exit();
        }
	else
        return parent::match($request);
    }
}
