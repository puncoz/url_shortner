<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *	Main Page Controller
 */
class main_page extends CI_Controller {

	/*
	 *	variable to hold data for view
	 */
	var $data = array();

	/*
	 *	Pagination per page
	 *	No. of content to be displayed per page of pagination
	 */
	var $pagination_per_page = 10;

	/*
	 *	Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view('main_page',$this->data);
	}
	
} // end of Dashboard Class