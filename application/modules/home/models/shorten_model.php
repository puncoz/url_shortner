<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	URL Shorten Model
*/
class Shorten_model extends CI_model {

	/*
	 *	Whether to check for url existent or not	
	 */
	private static $UrlExistsCheck = TRUE;

	/*
	 *	Database table name of url list	
	 */
	private static $db_tblname = 'url_list';
	
	function __construct() {
		// some thing while instantiated
	}

	public function validateUrlFormat($url = '') {
		if ($url == '') {
			return FALSE;
		}
		return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
	}

	public function checkUrlExists($url = '') {
		if ($url == '') {
			return FALSE;
		}

		if ( ! self::$UrlExistsCheck) {
			// do not check for url validity
			return TRUE;
		}
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
 
        return (!empty($response) && $response != 404);
	}

	public function checkUrlInDb($url = '') {
		if ($url == '') {
			return FALSE;
		}

		$query = $this->db->get_where(self::$db_tblname, array('LONG_URL'=>$url),1);
		if($query->num_rows() > 0) {
			return $query->row()->SHORT_CODE;
		} else {
			return FALSE;
		}
	}

	public function createShortUrl($url = '') {
		if($url == '' || empty($url)) {
			return FALSE;
		}

		
	}

}