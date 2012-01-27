<?php defined('SYSPATH') or die('No direct script access.');

class Log_Writer_File extends Log_Writer {

	protected $_directory;

	public function __construct($directory)
	{
		if ( ! is_dir($directory) OR ! is_writable($directory))
		{
			throw new Kohana_Exception('Directory :dir must be writable',
				array(':dir' => Debug::path($directory)));
		}

		$this->_directory = realpath($directory).DIRECTORY_SEPARATOR;
		register_shutdown_function(array($this, 'update_session'));
	}

	public function write(array $messages)
	{
		if (!file_exists($filename = $this->_directory.date('d.m.Y').'.php'))
		{
			file_put_contents($filename, '<?php die();?>'.PHP_EOL);
		}

		foreach ($messages as $message)
		{
			$log_cnt = $this->_format($message);
			file_put_contents($filename, PHP_EOL.$log_cnt, FILE_APPEND);
		}
	}

	protected function _format($message)
	{
		$return = $message['time'].' ';
		$return .= '['.strtolower($this->_log_levels[$message['level']]).'] ';

		$body = !empty($message['body']) ? str_replace(array("\r\n", "\n"), "*", $message['body']) : '';
		
		if(!(is_string($body))) 
		{
			$body = str_replace("\n", '', var_export($body, true));
		}
		
		$return .= 'message: "'.$body.'" ';

		$return .= 'client: '.Request::$client_ip.' ';

		$return .= 'uri: '.$_SERVER['REQUEST_URI']." ";

		if (isset($_SERVER['HTTP_REFERER']))
		{
			$return .= 'referer: '.$_SERVER['HTTP_REFERER']." ";
		}
		else 
		{
			$return .= 'referer: "" ';
		}

		$return .= 'agent: "'.$_SERVER['HTTP_USER_AGENT'].'" ';

		$return .= 'cookie: "'.str_replace("\n", '', var_export($_COOKIE, true)).'" ';

		return $return;
	}

	public function update_session()
	{
		Session::instance('native')->set('log_writer', __CLASS__);	
	}
	
} // End Log_Writer_File

