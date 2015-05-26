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

	/*
	 *	Characters to be used in shorted url code
	 */
	private static $chars = 'abcdefghjkmnpqrstwxyz123456789ABCDEFGHJKLMNPQRSTWXYZ';

	/*
	 *	Whether to insert short code in database or not	
	 */
	private static $insertShortCodeInDB = TRUE;
	
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

		$this->db->insert(self::$db_tblname, array('LONG_URL'=>$url));

		if ($this->db->affected_rows() > 0) {
			$id = $this->db->insert_id();
			if(is_int($id)) {
				$short_code = $this->convertIdToShortCode($id);
				if ($short_code === FALSE) {
					return FALSE;
				} else {					
					if (self::$insertShortCodeInDB) {
						// update short code in database
						$this->db->update(self::$db_tblname, array('SHORT_CODE'=>$short_code), array('id' => $id));
						if ($this->db->affected_rows() > 0) {
							return $short_code;
						} else {
							// update failed
							// revert inserted long url
							$this->revertInsertedUrl($url);
							return FALSE;
						}
					} else {
						return $short_code;
					}
				}
			} else {
				// invalid id
				// revert inserted long url
				$this->revertInsertedUrl($url);
				return FALSE;
			}			
		} else {
			return FALSE;
		}
	}

	public function revertInsertedUrl($url = '') {
		if ($url == '' || empty($url)) {
			return;
		}
		return $this->db->delete(self::$db_tblname,array('LONG_URL'=>$url));
	}

	public function convertIdToShortCode($id) {
		if ($id == '' || empty($id)) {
			return FALSE;
		}

		$id = intval($id);
        if ($id < 1) {
            return FALSE;
        }
 
        $length = strlen(self::$chars);
        // make sure length of available characters is at
        // least a reasonable minimum - there should be at
        // least 10 characters
        if ($length < 10) {
            throw new Exception("Length of chars is too small");
        }
 
        $code = "";
        while ($id > $length - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            $code = self::$chars[fmod($id, $length)] .
                $code;
            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }
 
        // remaining value of $id is less than the length of
        // self::$chars
        $code = self::$chars[$id] . $code;
 
        return $code;
	}

}