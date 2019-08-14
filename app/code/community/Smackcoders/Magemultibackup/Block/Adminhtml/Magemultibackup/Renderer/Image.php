<?php
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
    public function render(Varien_Object $row)   {
	$imgmodel = Mage::getModel("magemultibackup/magemultibackup")->load($row->getId());
	$errorstatues = $imgmodel->getStatus();
	$html = null;
	if($errorstatues == 0){
        $html = '<img src="'.$this->getSkinurl('images/error_msg_icon.gif').'" style = "margin-left:15px;"/>';
	}
	elseif($errorstatues == 1)
        $html = '<img src="'.$this->getSkinurl('images/success_msg_icon.gif').'" style = "margin-left:15px;"/>';
	elseif($errorstatues == 2)
        $html = '<img src="'.$this->getSkinurl('images/note_msg_icon.gif').'" style = "margin-left:15px;"/>';
        return $html;
    }
}
