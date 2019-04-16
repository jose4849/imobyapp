<?php
/**
 * File download class for inline, attachment downloads for whatever content type.
 * Allows for a file name, URL path to a file, or an input string.
 * 
 * @package lib
 * @author DPassey
 * @copyright 2008, Everett Public Schools
 * @version 1.0, 08.20.2008
 *
 */
	class EPSDownload
	{
/**
 * Default content type
 *
 * @var String
 */
		private $contentType = 'application/octet-stream';
		
/**
 * Default attachment type
 *
 * @var String
 */
		private $attachType = 'inline';
		
/**
 * Default cache control
 *
 * @var String
 */
		private $cache = 'no-cache, must-revalidate';
		
/**
 * Default pragma type for backward HTTP/1.0 compatibility
 *
 * @var String
 */
		private $pragma = 'no-cache';
		
/**
 * Download file description
 *
 * @var String
 */
		private $description = '';
		
/**
 * Cache expiration time
 *
 * @var Int
 */
		private $expires = 0;
		
/**
 * File name to process
 *
 * @var String
 */
		private $fileName = NULL;
		
/**
 * Download file name
 *
 * @var String
 */
		private $downloadName = '';
		
/**
 * Temporary file being used flag.
 *
 * @var Boolean
 */
		protected $isTemp = FALSE;
		
/**
 * Header modified GMT, which is always modified
 *
 * @var String
 */
		protected $headerModified;
		
/**
 * Header disposition
 *
 * @var String
 */
		protected $headerDisposition;
		
/**
 * Header file length
 *
 * @var Int
 */
		protected $headerLength;
		
/**
 * Header file description
 *
 * @var String
 */
		protected $headerDescription;
		
/**
 * Header file type
 *
 * @var String
 */
		protected $headerType;
		
/**
 * Header pragma
 *
 * @var String
 */
		protected $headerPragma;
		
/**
 * Header cache control
 *
 * @var String
 */
		protected $headerCacheControl;
		
/**
 * Header expiration
 *
 * @var String
 */
		protected $headerExpiration;
		
/**
 * Header array
 *
 * @var Array
 */
		private $headers = array();
		
/* Private methods */
		
/**
 * Sets the attachment type (inline || attachment).
 *
 * @param String $str
 * @return void
 */
		private function setAttachType ($str = '')
		{
			$this->attachType = (trim($str)) ? strtolower(trim($str)) : $this->attachType;
		}
		
/**
 * Sets the file content length.
 * 
 * @return void
 */
		private function setContentLength()
		{
			$this->headerLength = sprintf("Content-Length: %d",filesize($this->fileName));
		}
		
/**
 * Checks the file for existance and readability.
 *
 * @return Boolean
 */
		private function validateFile()
		{
			if (is_readable($this->fileName))
			{
				$this->setContentLength();
				return TRUE;
			}
			else return FALSE;
		}
		
/**
 * Sets the header array so that they are sent out in the correct order.
 *
 * @return Boolean
 */
		private function setHeaders()
		{
			/* Note: Do not change the order unless you know what you are doing! */
			$this->headers[] = $this->headerExpiration;
			$this->headers[] = $this->headerModified;
			$this->headers[] = $this->headerPragma;
			$this->headers[] = $this->headerCacheControl;
			$this->headers[] = $this->headerType;
			$this->headers[] = $this->headerLength;
			$this->headers[] = $this->headerDescription;
			$this->headers[] = $this->headerDisposition;
			return (count($this->headers) > 0) ? TRUE : FALSE;
		}
		
/**
 * Sets the file content disposition.
 * 
 * @return void
 */
		private function setContentDisposition()
		{
			$this->headerDisposition = sprintf("Content-Disposition: %s; filename=%s",$this->attachType,$this->downloadName);
		}
		
/**
 * Sets the last modified.
 *
 * @return void
 */
		private function setLastModified()
		{
			$this->headerModified = sprintf("Last-Modified: %s %s",gmdate("D, d M Y H:i:s"),' GMT');
		}
		
/**
 * Sets up a temporary file to hold the data string for later reading.
 * Uses the OS temp directory and sets isTemp var to TRUE.
 *
 * @param String $str
 * @return void
 */
		private function setTempFile($str = '')
		{
			if (trim($str))
			{
				$tempFile = sys_get_temp_dir() . mt_rand();
				while (!file_exists($tempFile))
				{
					if (file_put_contents($tempFile, "$str") !== FALSE) $this->fileName = $tempFile;
					else $tempFile = sys_get_temp_dir() . mt_rand();
				}
				$this->isTemp = TRUE;
			}
		}
		
/* Public methods */
		
/**
 * Constructor.
 *
 * @param String $name Name of the file or string to process.
 * @param String $type Attachement type (inline || attachment).
 * @param Boolean $useTempFile Set to TRUE if a temporary file is needed.  Implies then that $name is a string of data.
 * @see validateFile()
 * @return void
 */
		public function __construct($name = NULL, $type = 'inline', $useTempFile = 0)
		{
			if ($useTempFile) $this->setTempFile($name);
			else $this->fileName = (trim($name)) ? trim($name) : NULL;
			if ($this->validateFile()) $this->setAttachType($type);
		}
		
/**
 * Destructor.
 * Delete the temp file if one was created.
 *
 * @return void
 */
		public function __destruct()
		{
			if ($this->isTemp) @unlink($this->fileName);
		}
		
/**
 * Sets the content type header string.
 *
 * @param String $str
 * @return void
 */
		public function setContentType($str = '')
		{
			$this->contentType = (trim($str)) ? strtolower(trim($str)) : $this->contentType;
			$this->headerType = sprintf("Content-Type: %s",$this->contentType);
		}
		
/**
 * Sets the cache control header string.
 *
 * @param String $str
 * @return void
 */
		public function setCacheControl($str = '')
		{
			$this->cache = (trim($str)) ? strtolower(trim($str)) : $this->cache;
			$this->headerCacheControl = sprintf("Cache-Control: %s",$this->cache);
		}

/**
 * Sets the description header string.
 *
 * @param String $str
 * @return void
 */
		public function setDescription($str = '')
		{
			$this->description = (trim($str)) ? trim($str) : $this->description;
			$this->headerDescription = sprintf("Content-Description: %s",$this->description);
		}
		
/**
 * Sets the pragma header string.
 *
 * @param String $str
 * @return void
 */		
		public function setPragma($str = '')
		{
			$this->pragma = (trim($str)) ? strtolower(trim($str)) : $this->pragma;
			$this->headerPragma = sprintf("Pragma: %s",$this->pragma);
		}
		
/**
 * Sets the expiration time header string.
 *
 * @param Int $x
 * @return void
 */
		public function setExpiration($x = 0)
		{
			$this->expires = ($x > 0) ? $x : $this->expires;
			$this->headerExpiration = sprintf("Expires: %d",$this->expires);
		}
		
/**
 * Sets the file download name.
 *
 * @param String $str
 * @return void
 */
		public function setDownloadName($str = '')
		{
			$this->downloadName = (trim($str)) ? trim($str) : $this->fileName;
		}
		
/**
 * Sets all the necessary variables and header strings and sets them in the header array.
 * Reads the file into the browser is headers are sent correctly.
 * 
 * @see setHeaders()
 * @return void
 */
		public function execute()
		{
			$this->setDownloadName($this->downloadName);
			$this->setContentLength();
			$this->setDescription($this->description);
			$this->setContentType($this->contentType);
			$this->setContentDisposition();
			$this->setLastModified();
			$this->setPragma($this->pragma);
			$this->setCacheControl($this->cache);
			$this->setExpiration($this->expires);
			if ($this->setHeaders()) 
			{
				foreach ($this->headers as $head) header("$head");
				readfile($this->fileName);
			}
			else exit("Download failed.");
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
?>