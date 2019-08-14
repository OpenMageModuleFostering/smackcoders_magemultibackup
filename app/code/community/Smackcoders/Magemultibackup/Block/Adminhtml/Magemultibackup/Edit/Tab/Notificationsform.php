<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Edit_Tab_Notificationsform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('magemultibackup_form', array('legend'=>Mage::helper('magemultibackup')->__('Email Notifications')));
        $fieldset->addField('notifications', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Enabled'),
            'name'      => 'notifications',
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
          'after_element_html' => '<small>Email Notifications.</small>',
	'readonly'=>true,
	'disabled' => true,

        ));

        $fieldset->addField('sender', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Sender'),
            'name'      => 'sender',
            'values'    => array(
                array(  
                    'value'     => 'general',
                    'label'     => Mage::helper('magemultibackup')->__('General Contact'),
                ),

                array(
                    'value'     => 'sales',
                    'label'     => Mage::helper('magemultibackup')->__('Sales Representative'),
                ),
                array(
                    'value'     => 'support',
                    'label'     => Mage::helper('magemultibackup')->__('Customer Support'),
                ),
                array(
                    'value'     => 'custom1',
                    'label'     => Mage::helper('magemultibackup')->__('Custom Email 1'),
                ),
                array(
                    'value'     => 'custom2',
                    'label'     => Mage::helper('magemultibackup')->__('Custom Email 2'),
                ),
            ),  
          'after_element_html' => '<small>Mail Sender.</small>',
        'readonly'=>true,
//      'disabled' => true,
            
        ));

$templates = array();
$collections = Mage::getResourceSingleton('core/email_template_collection');
$r= 0;
foreach($collections as $collection)
{
$templates[$r]['value'] = $collection->getId();
$templates[$r]['label'] = $collection->getTemplate_code();
}

$fieldset->addField('emailtemplate', 'select', array(
          'label'     => Mage::helper('magemultibackup')->__('Email Temaplate'),
//          'class'     => 'required-entry',
          'required'  => false,
          'name'      => 'emailtemplate',
 //         'onclick' => "alert('on click');",
  //        'onchange' => "alert('on change');",
   //       'style'   => "border:10px",
//          'value'  => 'hello !!',
      //    'disabled' => false,
    //      'readonly' => true,
	  'values' => $templates,
          'after_element_html' => '<small>Mail Template.</small>',
          'tabindex' => 1
        ));

$fieldset->addField('sendmailcopy', 'text', array(
          'label'     => Mage::helper('magemultibackup')->__('Send Notification Email Copy To'),
//          'class'     => 'required-entry',
          'required'  => false,
          'name'      => 'sendmailcopy',
 //         'onclick' => "alert('on click');",
  //        'onchange' => "alert('on change');",
   //       'style'   => "border:10px",
//          'value'  => 'hello !!',
      //    'disabled' => false,
    //      'readonly' => true,
          'after_element_html' => '<small>Comma-separated.</small>',
          'tabindex' => 1
        ));


/*$fieldset->addField('ftppath', 'text', array(
          'label'     => Mage::helper('magemultibackup')->__('Path'),
//          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
 //         'onclick' => "alert('on click');",
  //        'onchange' => "alert('on change');",
   //       'style'   => "border:10px",
//          'value'  => 'hello !!',
      //    'disabled' => false,
    //      'readonly' => true,
          'after_element_html' => '<small>FTP\'s Path must be writable.</small>',
          'tabindex' => 1
        ));*/
        $fieldset->addField('emailmethod', 'select', array(
            'label'     => Mage::helper('magemultibackup')->__('Send Notification Email Copy Method'),
            'name'      => 'emailmethod',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('magemultibackup')->__('Bcc'),
                ),

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('magemultibackup')->__('Seperate Email'),
                ),
            ),
          'after_element_html' => '<small>Email Notifications.</small>',
        'readonly'=>true,
//      'disabled' => true,

        ));


        if ( Mage::getSingleton('adminhtml/session')->getMagemultibackupData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMagemultibackupData());
            Mage::getSingleton('adminhtml/session')->setMagemultibackupData(null);
        } elseif ( Mage::registry('magemultibackup_data') ) {
            $form->setValues(Mage::registry('magemultibackup_data')->getData());
        }
/*
     $this->setChild(
            'form_after',
            $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                ->addFieldMap('ftp', 'ftp')
                ->addFieldMap('ftppath', 'ftppath')
                ->addFieldMap('ftpserver', 'ftpserver')
                ->addFieldMap('ftpuser', 'ftpuser')
                ->addFieldMap('ftppassword', 'ftppassword')
                ->addFieldDependence('ftppath', 'ftp', '1')
                ->addFieldDependence('ftpserver', 'ftp', '1')
                ->addFieldDependence('ftpuser', 'ftp', '1')
                ->addFieldDependence('ftppassword', 'ftp', '1')
        );*/
        return parent::_prepareForm();
    }
}
