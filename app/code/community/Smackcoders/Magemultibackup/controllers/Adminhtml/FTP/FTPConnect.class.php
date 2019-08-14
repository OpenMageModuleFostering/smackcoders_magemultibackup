<?php
class FTPConnect {
	
	private
		$hostname,				
		$username,
		$password,
		$port = 21,
		$timeout = 120,
		$ftp_stream,
		$transfer_mode = FTP_BINARY,// two types of transfer modes FTP_ASCII and FTP_BINARY
		$error = array();
		
	function __construct($hostname, $username, $password, $port = '', $timeout = '') {
		
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		
		if($port && is_numeric($port)) $this->port = $port;
		if($timeout && is_numeric($timeout)) $this->timeout = $timeout;
	}
	
	private function ftp_connect() {
		
		if($this->ftp_stream) return true;		
		
		$this->ftp_stream = ftp_connect($this->hostname, $this->port, $this->timeout);
               // if(!$this->ftp_authorize()) return false;
		if($this->ftp_stream) return true;
       if(!$this->ftp_authorize()) return false;	
			$this->error('Unable to connect the host - '. $this->hostname .'through FTP');
		
		return false;			
	}
	
	function close_ftp_connection() {
		
		if(!$this->ftp_stream) return false;
		
		if(!ftp_close($this->ftp_stream)) {
			
			$this->error('FTP connection could not be closed on &quot;'. $hostname .'&quot; this host.');
			return false;
		}
		
		$this->ftp_stream = false;
		return true;
	}
	
	private function ftp_authorize() {
		
		if(!$this->ftp_connect()) return false;
		
		$res = ftp_login($this->ftp_stream, $this->username, $this->password);
		
		if($res) return true;
		
		$this->error('Check your credentials in settings, unable to login to FTP.');
		
		return false;
	}
	
	private function ftp_put_file($src_file, $dest_file, $transfer_mode) {
		
		if(!$this->ftp_authorize()) return false;
		if($transfer_mode != FTP_ASCII && $transfer_mode != FTP_BINARY)
			$transfer_mode = $this->transfer_mode;
		if(ftp_put($this->ftp_stream, $dest_file, $src_file, $transfer_mode)) return true;
		
		$this->error('Unknown error while uploading, please check the FTP directory.');
		
		return false;
	}
	private function ftp_get_file($sourceFile,$destFile,$transfer_mode){

		if(!$this->ftp_authorize()) return false;
                if($transfer_mode != FTP_ASCII && $transfer_mode != FTP_BINARY)
                        $transfer_mode = $this->transfer_mode;
                if(ftp_get($this->ftp_stream, $destFile, $sourceFile, $transfer_mode)) return true;
                $this->error('Unknown error while downloading, please check the FTP directory.');
		return false;
	}
	
	private function error($error) {
		
		if(!$error) return false;
		
		$this->error[] = $error;
		
		return true;			
	}
	
	public function get_file_lists($remote_dir = '.', $file_with_full_info = false, $recursive = false) {
		
		if(!$this->ftp_authorize()) return false;
	//	if($remote_dir) $remote_dir = '.';//commented by prem
		
		if($file_with_full_info == false && $recursive == false) {
			$files = ftp_nlist($this->ftp_stream, "-la {$remote_dir}");
			
			if($files !== FALSE) return $files;
			
			$this->error('There was a problem while getting a file list &quot;'. $remote_dir .'&quot;');
		
			return false;			
		}// endif
		$files = ftp_rawlist($this->ftp_stream, "-la {$remote_dir}", $recursive);
		if($files !== FALSE) return $files;
		
		$this->error('There was a problem while getting a file list &quot;'. $remote_dir .'&quot;');
	
		return false;
	}
	
	/**
	 *
	 *	@params
	 *		@src_file - string, required, local file, it should be either file name or full path country.txt or /var/www/html/country.txt
	 *		@dest_file - string, required, remote file name, it should be either file name or full path country.txt or /var/www/html/country.txt
	 *
	**/
	function upload_file($src_file, $dest_file, $transfer_mode = FTP_ASCII) {
		
		if(!$this->ftp_connect()) return false;
		
		return $this->ftp_put_file($src_file, $dest_file, $transfer_mode);
	}
	function download_file($remoteFile,$localpath, $transfer_mode = FTP_ASCII){
                if(!$this->ftp_connect()) return false;
		return $this->ftp_get_file($remoteFile,$localpath, $transfer_mode);

	}	
	
	public function get_error() {
		
		return $this->error;
	}
	
	public function show_error($flag = true) {
		
		$error = '';
		
		$errors = $this->get_error();
		
		if(!is_array($errors) || !count($errors)) return false;
		
		foreach($errors as $key => $err) {
			$error .= $err;
			
		}
		if($flag) {
			return $error;
			return true;
		}
		
		return $error;
	}
}
