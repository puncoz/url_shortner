
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *	Redirect Controller
 */
class Redirect extends MX_Controller {

	/*
	 *	variable to hold data for view
	 */
	var $data = array();

	/*
	 *	Constructor
	 */
	public function __construct() {
		parent::__construct();

		// load shorten model
		$this->load->model('shorten_model');
	}

	public function index($short_code) {
		try {
			if (empty($short_code)) {
				throw new Exception('Short URL not found!!!');
			}

			if($this->shorten_model->checkShortCodeFormat($short_code) === FALSE) {
				throw new Exception('Short URL is in invalid format.');
			}

			$long_url = $this->shorten_model->getLongUrlFromDB($short_code);
			if ($long_url == FALSE) {
				throw new Exception('URL does not exists.');
			}

			redirect($long_url, 'location', 301);

		} catch (Exception $e) {
			
		}
	}
	
} // end of Redirect Class