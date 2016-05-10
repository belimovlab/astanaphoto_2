<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Themelib {

        protected $CI;
        protected  $data;


        public function __construct()
        {
            $this->CI =& get_instance();
        }

        public function getSessionValue($session_item_name)
        {
            $tmp_value = $this->CI->session->userdata($session_item_name);
            $this->CI->session->unset_userdata($session_item_name);
            return $tmp_value;
        }
        
        public function get_header($title='', $css = '', $data = [])
        {
            $this->data['title'] = $title ? $title : MainSiteConfig::get_item('site_title');
            if(is_array($css))
            {
                $this->data['css'] = array_unique($css);
            }
            else
            {
                $this->data['css'] = array_unique(explode(',', $css));
            }
            if(!empty($data))
            {
                $this->data           = array_merge($this->data,$data);
            }
            return $this->CI->load->view('/theme/header',  $this->data,TRUE);
        }

        public function get_footer($js='')
        {
            if(is_array($js))
            {
                $this->data['js']    = array_unique($js);
            }
            else
            {
                $this->data['js']    = array_unique(explode(',', $js));
            }
            return $this->CI->load->view('/theme/footer',  $this->data,TRUE);
        }
        
}

/* End of file Auth.php */