<?php

/**
* upload class
*/
class Upload
{
	private $fileName;
	private $uploadDir;
	private $allowExt;
	private $allowMime;
	private $bImg;
	
	private $fileInfo;
	private $error;
	private $ext;

	private $uniqueName;
	private $dest;



	function __construct($fileName='uploadfile', $uploadDir='./uploads', $bImg=true, $maxSize=5242880, $allowExt=array('jpeg','jpg','png','gif'), $allowMime=array('image/jpeg', 'image/png', 'image/gif'))
	{
		$this->fileName = $fileName;
		$this->uploadDir = $uploadDir;
		$this->bImg = $bImg;
		$this->maxSize = $maxSize;
		$this->allowExt = $allowExt;
		$this->allowMime = $allowMime;
		$this->fileInfo = $_FILES[$fileName];
	}

	/**
	 * check file upload error
	 * @return boolean 
	 */
	public function checkError()
	{
		if (!is_null($this->fileInfo)) {
			if ($this->fileInfo['error'] > 0) {
				switch ($this->fileInfo['error']) {
					case 1:
						$this->error='超过了PHP配置文件中upload_max_filesize选项的值';
						break;
					case 2:
						$this->error='超过了表单中MAX_FILE_SIZE设置的值';
						break;
					case 3:
						$this->error='文件部分被上传';
						break;
					case 4:
						$this->error='没有选择上传文件';
						break;
					case 6:
						$this->error='没有找到临时目录';
						break;
					case 7:
						$this->error='文件不可写';
						break;
					case 8:
						$this->error='由于PHP的扩展程序中断文件上传';
						break;
				}
				return false;
			} else {
				return true;
			}
		} else {
			$this->error='文件上传出错';
			return false;
		}
	}

	/**
	 * check file size
	 * @return boolean 
	 */
	public function isFileSizeValid()
	{
		if ($this->fileInfo['size'] > $this->maxSize) {
			$this->error = '上传文件过大';
			return false;
		}
		return true;
	}

	/**
	 * check file extension
	 * @return boolean 
	 */
	public function isFileExtValid()
	{
		$this->ext = strtolower(pathinfo($this->fileInfo['name'], PATHINFO_EXTENSION));
		if (!in_array($this->ext, $this->allowExt)) {
			$this->error = '不允许的文件扩展名';
			return false;
		}
		return true;
	}

	/**
	 * check file type
	 * @return boolean 
	 */
	public function isFileMimeValid()
	{
		if (!in_array($this->fileInfo['type'], $this->allowMime)) {
			$this->error = '不允许的文件类型';
			return false;
		}
		return true;
	}

	/**
	 * check file is img?
	 * @return boolean 
	 */
	public function isImgFile()
	{
		if ($this->bImg) {
			if (!@getimagesize($this->fileInfo['tmp_name'])) {
				$this->error = '不是图片文件';
				return false;
			}
			return true;
		}
		return false;
	}


	/**
	 * check is http post method uploaded
	 * @return boolean 
	 */
	public function isHttpPost()
	{
		if (!is_uploaded_file($this->fileInfo['tmp_name'])) {
			$this->error = '文件不是post方法上传的';
			return false;
		}
		return true;
	}

	/**
	 * check upload directory, not exits then create it.
	 * @return void
	 */
	public function checkUploadDir()
	{
		if (!file_exists($this->uploadDir)) {
			mkdir($this->uploadDir, 0755, true);
		}
	}

	/**
	 * generate unique string
	 * @return string 
	 */
	public function getUniqueName()
	{
		return md5(uniqid(microtime(true), true));
	}

	public function displayError()
	{
		exit('<span style="color:red">'.$this->error.'</span>');
	}

	public function uploadFile()
	{
		if ($this->checkError() && 
			$this->isFileSizeValid() && 
			$this->isFileExtValid() &&
			$this->isFileMimeValid() &&
			$this->isImgFile() &&
			$this->isHttpPost()) {

			
			$this->checkUploadDir();
			$this->uniqueName = $this->getUniqueName();
			$this->dest = $this->uploadDir.'/'.$this->uniqueName.'.'.$this->ext;
			if (@move_uploaded_file($this->fileInfo['tmp_name'], $this->dest)) {
				return $this->dest;
			} else {
				$this->error = '文件移动失败';
			}
		}
		$this->displayError();
	}
}

