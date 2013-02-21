<?php defined('SYSPATH') or die('No direct script access.');

class Log_Writer_Database extends Log_Writer {

	public function __construct()
	{
		register_shutdown_function(array($this, 'update_session'));
	}

	/**
	 * Запись лог в БД
	 *
	 * @see Kohana_Log_Writer::write()
	 * @return void
	 */
	public function write(array $messages)
	{
		$log = new Model_Log;

		foreach ($messages as $message)
		{
			$log->values($this->_format($message))->create();
                                                     $log->clear();
		}
	}

	/**
	 * Форматирование ошибок для записи в БД
	 *
	 * @param array $message
	 * @return array
	 */
	protected function _format($message)
	{
		$return = array();
		$return['time'] = Date::formatted_time('now', 'Y-m-d H:i:s', Log::$timezone);
		$return['level'] = strtoupper($this->_log_levels[$message['level']]);
		$return['message'] = $message['body'];
		$return['client'] = Request::$client_ip;
		$return['uri'] = $_SERVER['REQUEST_URI'];
		$return['referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$return['agent'] = $_SERVER['HTTP_USER_AGENT'];
		$return['cookie'] = var_export($_COOKIE, true);

		return $return;
	}

	public function update_session()
	{
		Session::instance()->set('log_writer', __CLASS__);
	}

} // End Log_Writer_Database

