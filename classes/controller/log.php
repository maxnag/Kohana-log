<?php
class Controller_Log extends Controller 
{
	/**
	 * @var  string  page template
	 */
	public $template = 'template';

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;	
	
	public function action_download()
	{
		$date = $this->request->param('date', date('d.m.Y'));
		
		$this->response->send_file(APPPATH.'logs'.DIRECTORY_SEPARATOR.$date.EXT, 'log_'.$date.EXT, array('mime_type'=>'text/plain'));
	}
	
	public function action_view()
	{
		$type = Session::instance()->get('log_writer');
		
		switch ($type)
		{
			case "Log_Writer_File":
			default :
				$date = $this->request->param('date', date('d.m.Y'));
				$log_dir = APPPATH.'logs';
				
				if (!file_exists($log_file = $log_dir.DIRECTORY_SEPARATOR.$date.EXT))
				{
					file_put_contents($log_file, '<?php die();?>'.PHP_EOL);
					throw new Log_Exception('log file :file not exists', array(
						':file' => $log_file,
					));
				}

				$logs = Log_Parser::parse_file($log_file);
				$type_view = 'file';
				break;
			case "Log_Writer_Database":
				$date = $this->request->param('date', date('d.m.Y'));
				$date_to_sql = Date::formatted_time($date, 'Y-m-d');
				$query_b = DB::expr(' `time` BETWEEN "'.$date_to_sql.' 00:00:00" ');
				$query_e = DB::expr(' AND "'.$date_to_sql.' 23:59:59" ');
							
				$logs = ORM::factory('log')->where($query_b, '', $query_e)->order_by('id', 'ASC')->find_all();

				$type_view = 'database';
				break;
		}

		$this->template = View::factory('log_view_'.$type_view)->set('logs', $logs)->set('date', $date);
	}
	
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			$this->response->body($this->template->render());
		}

		return parent::after();
	}	
}