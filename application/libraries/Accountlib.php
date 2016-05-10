<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Accountlib {

        protected $CI;
        protected  $data;


        public function __construct()
        {
            $this->CI =& get_instance();
        }

        public function is_loggined()
        {
            if($this->CI->session->userdata('user_info')->id)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
}

/* End of file Auth.php */