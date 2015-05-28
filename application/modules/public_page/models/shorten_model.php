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
	private static $valid_chars = 'abcdefghjkmnpqrstwxyz123456789ABCDEFGHJKLMNPQRSTWXYZ';

	/*
	 *	Whether to insert short code in database or not	
	 */
	private static $insertShortCodeInDB = TRUE;

	/*
	 *	Whether to keep hit count in database or not
	 */
	private static $hitCountIncrement = TRUE;
	
	function __construct() {
		// some thing while instantiated
	}

	/*******************************************
	 *	ENCODE SHORT CODE
	 *******************************************/
	public function validateUrlFormat($url = '') {
		if ($url == '') {
			return FALSE;
		}
		//return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
		return preg_match('|^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$|', $url);
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
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$response = curl_exec($ch);
		$response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
 
        return (!empty($response_status) && $response_status != '404');
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

	public function convertIdToShortCode($id = '') {
		if ($id == '' || empty($id)) {
			return FALSE;
		}

		$id = intval($id);
        if ($id < 1) {
            return FALSE;
        }
 
        $length = strlen(self::$valid_chars);
        // make sure length of available characters is at
        // least a reasonable minimum - there should be at
        // least 10 characters
        if ($length < 10) {
            throw new Exception("Length of chars is too small");
        }
 
        $code = '';
        //$id *= 138 * time();
        $id = time();
        //echo $id.'/';
        while ($id > $length - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            //echo 'l='.$length.'/';
            //echo bcmod($id,$length).'/';
            // echo self::$valid_chars[(int)($id%$length)];
            $code .= self::$valid_chars[bcmod($id,$length)];
            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }
 
        // remaining value of $id is less than the length of
        // self::$valid_chars
        $code .= self::$valid_chars[(int)$id];
 
        return $code;
	}

	/*******************************************
	 *	DECODE SHORT CODE
	 *******************************************/
	public function checkShortCodeFormat($short_code = '') {
		if ($short_code == '' || empty($short_code)) {
			return FALSE;
		}
		return preg_match("|[" . self::$valid_chars . "]+|", $short_code);
	}

	public function getLongUrlFromDB($short_code = '') {
		if ($short_code == '' || empty($short_code)) {
			return FALSE;
		}

		$this->db->select('ID,LONG_URL,HIT_COUNTER');
		$query = $this->db->get_where(self::$db_tblname, array('SHORT_CODE'=>$short_code));
		if ($query->num_rows() > 0) {
			$result = $query->row();
			if (self:: $hitCountIncrement) {
				// increment hit count
				$this->db->update(self::$db_tblname, array('HIT_COUNTER'=>($result->HIT_COUNTER+1)), array('ID'=>$result->ID));
				if (($this->db->affected_rows() > 0)) {
					// database not updated
					// log the error
					//throw new Exception("Error Incrementing Hit Count");					
				}
			}
			return $result->LONG_URL;
		} else {
			return FALSE;
		}
	}

}