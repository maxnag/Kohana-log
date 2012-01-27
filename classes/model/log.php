<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Модель для обработки лога ошибок
 *
 * @package    system
 * @author Maxim Nagaychenko maxnag[at]meta.ua
 * @license
 */
class Model_Log extends ORM {
	
	public $rules = array();
	public $filters = array();
	public $labels = array();
		
	
	/**
	 * Правила валидации для модели
	 * 
	 * @see Kohana_ORM::rules()
	 * @return void
	 */
	public function rules()
    {
		return (count($this->rules)>0) ? $this->rules : array();
	}

    /**
     * Фильтрация данных
     * 
     * @see Kohana_ORM::filters()
     * @return void
     */
    public function filters()
    {
		return (count($this->filters)>0) ? $this->filters : array();
    }
    
    /**
     * Метки для полей
     * 
     * @see Kohana_ORM::labels()
     * @return void
     */
    public function labels()
    {
    	return (count($this->labels)>0) ? $this->labels : array();
    }
}// End Log Model