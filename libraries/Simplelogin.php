<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Simplelogin Class
 *
 * Makes authentication simple
 *
 * Simplelogin is released to the public domain
 * (use it however you want to)
 * 
 * Simplelogin expects this database setup
 * (if you are not using this setup you may
 * need to do some tweaking)
 * 

	#This is for a MySQL table
	CREATE TABLE `users` (
	`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`username` VARCHAR( 64 ) NOT NULL ,
	`password` VARCHAR( 64 ) NOT NULL ,
	UNIQUE (
	`username`
	)
	);

 * 
 */
class Simplelogin
{
	var $CI;
	var $user_table = 'user';

	function Simplelogin()
	{
		// get_instance does not work well in PHP 4
		// you end up with two instances
		// of the CI object and missing data
		// when you call get_instance in the constructor
		//$this->CI =& get_instance();
	}

	/**
	 * Create a user account
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function create($username = '', $password = '', $first_name = '', $last_name = '', $email = '', $auto_login = true) {
		//print_r($_POST);
		//exit();
		//Put here for PHP 4 users
		$this->CI =& get_instance();		

		//Make sure account info was sent
		if($username == '' OR $password == '') {
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('username', $username); 
		$query = $this->CI->db->getwhere($this->user_table);
		
		if ($query->num_rows() > 0) {
			//username already exists
			return false;
			
		} else {
			//Encrypt password
			$password = md5($password);
			$code = md5($email);
			
			//Insert account into the database
			$data = array(
						'username' => $username,
						'password' => $password,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email' => $email,
						'code' => $code
					);
			$this->CI->db->set($data); 
			if(!$this->CI->db->insert($this->user_table)) {
				//There was a problem!
				return false;						
			}
			$user_id = $this->CI->db->insert_id();
			$this->CI->session->set_userdata('user_id',$user_id);
			
			//Automatically login to created account
			if($auto_login) {		
				//Destroy old session
				$this->CI->session->sess_destroy();
				
				//Create a fresh, brand new session
				$this->CI->session->sess_create();
				
				//Set session data
				$this->CI->session->set_userdata(array('adminloginid' => $user_id,'username' => $username));
				
				//Set logged_in to true
				//$this->CI->session->set_userdata(array('logged_in' => true));			
			
			}
			
			//Login was successful			
			return true;
		}

	}

	/**
	 * Delete user
	 *
	 * @access	public
	 * @param integer
	 * @return	bool
	 */
	function delete($user_id) {
		//Put here for PHP 4 users
		$this->CI =& get_instance();
		
		if(!is_numeric($user_id)) {
			//There was a problem
			return false;			
		}

		if($this->CI->db->delete($this->user_table, array('adminloginid' => $user_id))) {
			//Database call was successful, user is deleted
			return true;
		} else {
			//There was a problem
			return false;
		}
	}


	/**
	 * Login and sets session variables
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function login($username = '', $password = '', $type = NULL) {
				
		//Put here for PHP 4 users
		$this->CI =& get_instance();
		
		if($username == '' || $password == '') {
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('username', $username); 
		$this->CI->db->where('password', md5($password));
		$this->CI->db->where('status', 1);
		if($type!=NULL) $this->CI->db->where('type', $type);
		$query = $this->CI->db->get($this->user_table);
	
		if ($query->num_rows() > 0) {
			$row = $query->row_array();	
						
			//Set logged_in to true
			$this->CI->session->set_userdata(array('user_id' =>$row['id'] , 'imobycode'=>$row['imobycode'], 'user_name' =>$row['username'] , 'logged_in' => true, 'user_type' => $row['type'],'member_type'=>$row['member_type']));			
			
			//Login was successful			
			//echo "Login was successful";			
			return true;
		} else {
			//No database result found
			//echo "No database result found";
			return false;
		}
	}
	
	/**
	 * Logout user
	 *
	 * @access	public
	 * @return	void
	 */
	function logout() {
		//Put here for PHP 4 users
		$this->CI =& get_instance();

		//Destroy session
		$this->CI->session->sess_destroy();
	}
}
?>