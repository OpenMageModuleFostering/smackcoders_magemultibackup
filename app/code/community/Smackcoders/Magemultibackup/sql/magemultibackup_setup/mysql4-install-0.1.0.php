<?php
$installer = $this;
 $skinurl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
$baseurl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
$installer->startSetup();

$installer->run("
 
-- DROP TABLE IF EXISTS {$this->getTable('magemultibackup')};
CREATE TABLE {$this->getTable('magemultibackup')} (
  `magemultibackup_id` int(11) unsigned NOT NULL auto_increment,
  `createdat` datetime Default NULL,
  `deletedat` datetime NULL,
  `action` varchar(255) NULL,
  `ftpied` varchar(255) NULL ,
  `localpath` varchar(255) NULL,
  `filename` varchar(255) NULL,
  `ftppath` varchar(255) NULL ,
  `error` varchar(255) NULL,
  `mode` varchar(255) NULL,
  `status` varchar(255) NULL,
  `ftpfiledeleted` varchar(255) NULL,
  `localfiledeleted` varchar(255) NULL,
  `fileid` varchar(255) NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`magemultibackup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('magemultibackupsettings')};
CREATE TABLE {$this->getTable('magemultibackupsettings')} (
  `magemultibackupsettings_id` int(11) unsigned NOT NULL auto_increment,
  `variable` varchar(255) NULL ,
  `value` longtext NULL,
  PRIMARY KEY (`magemultibackupsettings_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('magemultibackupscheduler')};
CREATE TABLE {$this->getTable('magemultibackupscheduler')}(
  `scheduler_id` int(11) unsigned NOT NULL auto_increment,
  `scheduletype` varchar(255) NULL,
  `starttime` varchar(255) NULL,
  `estimatedtime` varchar(255) NULL,
  `actualtime` varchar(255) NULL,
  `magemultibackupid` varchar(255) NULL,
  `status` varchar(255),
   PRIMARY KEY (`scheduler_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO {$this->getTable('magemultibackupsettings')} (variable,value) VALUES ('maintenancehtml','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\r\n<head>\r\n<title>{$this->pageTitle} </title>\r\n<base href=\" {$skinurl}\" />\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<meta name=\"description\" content=\"Maintanence Mode is activated as Smackcoders Multi Backup is in Action\" />\r\n<meta name=\"keywords\" content=\"Maintanence, Backup, Rollback, FTP, Magento\" />\r\n<meta name=\"robots\" content=\"*\" />\r\n<link rel=\"stylesheet\" href=\"css/styles.css\" type=\"text/css\" />\r\n<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/x-icon\" />\r\n<link rel=\"shortcut icon\" href=\"images/favicon.ico\" type=\"image/x-icon\" />\r\n</head>\r\n<body>\r\n    <div class=\"wrapper\">\r\n        <div class=\"page\">\r\n            <div class=\"header-container\">\r\n                <div class=\"header\">\r\n                    <a href=\"{$baseurl}\" title=\"Maintanence Mode is activated as Smackcoders Multi Backup is in Action\" class=\"logo\"><img src=\"images/logo.gif\" alt=\"Maintanence Mode is activated as Smackcoders Multi Backup is in Action\" /></a>\r\n                </div>\r\n            </div>\r\n            <div class=\"main-container\">\r\n                <div class=\"main col1-layout\">\r\n                    <!--?php require_once $contentTemplate; ?-->\r\n     <div  style=\"text-align: center;\">\r\n      <h1>Maintanence Mode</h1>\r\n      <h2>Smackcoders Multi Backup is in Action</h2>\r\n      <a href=\"http://www.smackcoders.com/mage-multi-backup-roolback-tool.html\"><img align=\"\" alt=\"Smackcoders Multi Backup Maintanence Mode is on. Com back again\" src=\"http://www.smackcoders.com//wp-content/uploads/2012/09/smackcoders-multi-backup-maintenance.png\"></a>\r\n      </div>\r\n    </div>\r\n            </div>\r\n            <div class=\"footer-container\">\r\n                <div class=\"footer\">\r\n                    <address class=\"copyright\">Copyright &copy; 2013 Smackcoders Multi Backup / Rollback</address>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</body>\r\n</html>');
    ");


$installer->endSetup();
