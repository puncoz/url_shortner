
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *	Home Page Controller
 */
class Home extends CI_Controller {

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

		// load shorten model
		$this->load->model('shorten_model');
	}

	public function index() {
		$this->data['page_info'] = array(
										'title' => 'Nepal\'s First URL shortener',
										'meta_keywords' => 'url shortner',
										'meta_description' => 'Nepal\'s One and Only Url Shortner.'
									);

		$this->data['page_content'] = $this->load->view('home_page', $this->data, TRUE);
		$this->load->view('templates/index_page',$this->data);
	}

	public function shorten_url() {
		if ($this->input->is_ajax_request()) {
			$long_url = $this->input->post('long_url');

			try {
				// checking for blank url
				if(empty($long_url)) {
					throw new Exception('No URL was supplied.');				
				}

				// checking for valid url
				if ($this->shorten_model->validateUrlFormat($long_url) === FALSE) {
					throw new Exception('Invalid URL Format.');
				}

				// checking for url existence
				if ($this->shorten_model->checkUrlExists($long_url) === FALSE) {
					throw new Exception('URL does not appear to be a valid one.');
				}

				// checking for url in database
				$short_url = $this->shorten_model->checkUrlInDb($long_url);
				if ($short_url === FALSE) {
					$short_url = $this->shorten_model->createShortUrl($long_url);
				}

				echo json_encode(array('status_code' => '200', 'status_msg' => 'Success' ,'short_url'=> $long_url));			
			} catch(Exception $e) {
				echo json_encode(array('status_code' => '400', 'status_msg' => $e->getMessage()));
			}
		} else {
			exit('No direct script access allowed');
		}
	}
	
} // end of Home Class