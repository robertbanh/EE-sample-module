<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taechogroup_mcp
{
	private $EE;
	private $base_url;
	private $data = array();

	// ==================
	// 
	// ==================
	public function __construct()
	{
		$this->EE =& get_instance();
		$this->base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=taechogroup';
		$this->form_action_base = AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=taechogroup';

		// update breadcrumbs
		$this->EE->cp->set_breadcrumb($this->base_url.AMP.'method=index', 'TaechoGroup');

		// set navigation
		$this->EE->cp->set_right_nav(array(
			'Home' => $this->base_url.AMP.'method=index',
		));

		// load models
		$this->EE->load->model('taechogroup_model');

	}

	// ==================
	// 
	// ==================
	public function index()
	{
		// sample of passing data to view
		$this->data['rbanh_data'] = 'hello world';

		// Set page title
		$this->EE->cp->set_variable('cp_page_title', 'Taechogroup Module');
		return $this->EE->load->view('index', $this->data, TRUE);
	}









	

}

