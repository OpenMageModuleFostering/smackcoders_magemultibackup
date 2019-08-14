<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tab_Settingslocalform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('magemultibackup_form', array('legend'=>Mage::helper('magemultibackup')->__('Local Backup')));
	$collmodels = Mage::getModel('magemultibackup/magemultibackupsettings')->getCollection();
	$getVal = Mage::getModel('magemultibackup/magemultibackupsettings');
	foreach($collmodels as $model){
		$assignVariables = $getVal->load($model->getId());
		$chkLocalVariab = $assignVariables->getVariable();
		if ($chkLocalVariab=='local')
		$local = $assignVariables->getValue();
		if($chkLocalVariab == 'localpath')
		$localpath = $assignVariables->getValue();
		if($chkLocalVariab == 'localscheduler')
		$localscheduler = $assignVariables->getValue();
		if($chkLocalVariab == 'localscheduletime')
		$localscheduletime = $assignVariables->getValue();
		if($chkLocalVariab == 'localschedulefrequency')
		$localschedulefrequency = $assignVariables->getValue();
		if($chkLocalVariab == 'localscheduleday')
		$localscheduleday = $assignVariables->getValue();
		if($chkLocalVariab == 'localschedulemonth')
		$localschedulemonth = $assignVariables->getValue();
		if($chkLocalVariab == 'ftp')
		$ftp = $assignVariables->getValue();
		if($chkLocalVariab == 'ftpserver')
		$ftpserver = $assignVariables->getValue();
		if($chkLocalVariab == 'ftpuser')
		$ftpuser = $assignVariables->getValue();
if($chkLocalVariab == 'ftppassword')
$ftppassword = $assignVariables->getValue();
if($chkLocalVariab == 'ftppath')
$ftppath = $assignVariables->getValue();
if($chkLocalVariab == 'ftpport')
$ftpport = $assignVariables->getValue();
}
//local backup settings form
        $fieldset->addField('local', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Enabled'),
            'name'      => 'local',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('magemultibackup')->__('Yes'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('magemultibackup')->__('No'),
                ),
            ),
          'after_element_html' => '<small>Store in local server.</small>',
	  'value' => $local,

        ));


	$fieldset->addField('localpath', 'text', array(
          'label'     => Mage::helper('magemultibackup')->__('Path'),
          'required'  => true,
          'name'      => 'localpath',
          'value'  => $localpath,
          'after_element_html' => '<small>Path must be writable and in magento store\'s root directory</small>',
          'tabindex' => 1
        ));

        $fieldset->addField('localscheduler', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Auto Schedule'),
            'name'      => 'localscheduler',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('magemultibackup')->__('Yes'),
                ),

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('magemultibackup')->__('No'),
                ),
            ),
          'after_element_html' => '<small></small>',
          'value' => $localscheduler,

        ));

       $fieldset->addField('localscheduletime', 'time', array(
          'label'     => Mage::helper('magemultibackup')->__('Time'),
          'name'      => 'localscheduletime',
          'onclick' => "",
          'onchange' => "",
          'value'  =>$localscheduletime,
          'disabled' => false,
          'readonly' => false,
 //         'after_element_html' => '<small>Comments</small>',
          'tabindex' => 1
        ));

/*        $fieldset->addField('localscheduleday', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Day'),
            'name'      => 'localscheduleday',
	    'width' 	=> 20,
	    'style'     =>'width:100px;',
            'values'    => array(
                array(
                    'value'     => 'daily',
                    'label'     => Mage::helper('magemultibackup')->__('Daily'),
                ),

                array(
                    'value'     => 'Sun',
                    'label'     => Mage::helper('magemultibackup')->__('Sun'),
                ),
                array(
                    'value'     => 'Mon',
                    'label'     => Mage::helper('magemultibackup')->__('Mon'),
                ),
                array(
                    'value'     => 'Tue',
                    'label'     => Mage::helper('magemultibackup')->__('Tue'),
                ),
                array(
                    'value'     => 'Wed',
                    'label'     => Mage::helper('magemultibackup')->__('Wed'),
                ),
                array(
                    'value'     => 'Thu',
                    'label'     => Mage::helper('magemultibackup')->__('Thu'),
                ),
                array(
                    'value'     => 'Fri',
                    'label'     => Mage::helper('magemultibackup')->__('Fri'),
                ),
                array(
                    'value'     => 'Sat',
                    'label'     => Mage::helper('magemultibackup')->__('Sat'),
                ),

            ),
          'after_element_html' => '<small></small>',
          'value' => $localscheduleday,

        ));
*/

        $fieldset->addField('localschedulefrequency', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Frequency'),
            'name'      => 'localschedulefrequency',
	    'width' 	=> 20,
	    'style'     =>'width:100px;',
            'values'    => array(
                array(
                    'value'     => 'D',
                    'label'     => Mage::helper('magemultibackup')->__('Daily'),
                ),

                array(
                    'value'     => 'W',
                    'label'     => Mage::helper('magemultibackup')->__('Weakly'),
                ),
                array(
                    'value'     => 'M',
                    'label'     => Mage::helper('magemultibackup')->__('Monthly'),
                ),
	     ),
          'value' => $localschedulefrequency,

        ));



/*        $fieldset->addField('localschedulemonth', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Month'),
            'name'      => 'localschedulemonth',
	    'width' 	=> 20,
	    'style'     =>'width:100px;',
            'values'    => array(
                array(
                    'value'     => '0',
                    'label'     => Mage::helper('magemultibackup')->__('Every Month'),
                ),

                array(
                    'value'     => '1',
                    'label'     => Mage::helper('magemultibackup')->__('Jan'),
                ),
                array(
                    'value'     => '2',
                    'label'     => Mage::helper('magemultibackup')->__('Feb'),
                ),
                array(
                    'value'     => '3',
                    'label'     => Mage::helper('magemultibackup')->__('Mar'),
                ),
                array(
                    'value'     => '4',
                    'label'     => Mage::helper('magemultibackup')->__('Apr'),
                ),
                array(
                    'value'     => '5',
                    'label'     => Mage::helper('magemultibackup')->__('May'),
                ),
                array(
                    'value'     => '6',
                    'label'     => Mage::helper('magemultibackup')->__('Jun'),
                ),
                array(
                    'value'     => '7',
                    'label'     => Mage::helper('magemultibackup')->__('Jul'),
                ),
                array(
                    'value'     => '8',
                    'label'     => Mage::helper('magemultibackup')->__('Aug'),
                ),
                array(
                    'value'     => '9',
                    'label'     => Mage::helper('magemultibackup')->__('Sep'),
                ),
                array(
                    'value'     => '10',
                    'label'     => Mage::helper('magemultibackup')->__('Oct'),
                ),
                array(
                    'value'     => '11',
                    'label'     => Mage::helper('magemultibackup')->__('Nov'),
                ),
                array(
                    'value'     => '12',
                    'label'     => Mage::helper('magemultibackup')->__('Dec'),
                ),
            ),
          'after_element_html' => '<small></small>',
          'value' => $localschedulemonth,

        ));*/




        if ( Mage::getSingleton('adminhtml/session')->getMagemultibackupData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMagemultibackupData());
            Mage::getSingleton('adminhtml/session')->setMagemultibackupData(null);
        } elseif ( Mage::registry('magemultibackup_data') ) {
            $form->setValues(Mage::registry('magemultibackup_data')->getData());
        }

        $this->setChild(
            'form_after',
            $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                ->addFieldMap('local', 'local')
                ->addFieldMap('localpath', 'localpath')
                ->addFieldMap('localscheduler', 'localscheduler')
                ->addFieldMap('localscheduletime', 'localscheduletime')
                ->addFieldMap('localschedulefrequency', 'localschedulefrequency')
                ->addFieldDependence('localpath', 'local', '1')
                ->addFieldDependence('localscheduler', 'local', '1')
                ->addFieldDependence('localscheduletime', 'local', '1')
                ->addFieldDependence('localschedulefrequency', 'local', '1')
                ->addFieldDependence('localschedulefrequency', 'localscheduler', '1')
                ->addFieldDependence('localscheduletime', 'localscheduler', '1')
        );
        return parent::_prepareForm();
    }
}
