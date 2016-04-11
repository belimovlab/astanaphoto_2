<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ganres_model extends CI_Model {

        

        public function __construct()
        {
                parent::__construct();
        }

        public function get_all_user_types()
        {
            $data = $this->db->order_by('id')->get('user_type');
            return $data->result();
        }
        
        
        public function get_all_user_types_array()
        {
            $data = $this->db->order_by('name')->get('user_type');
            return $data->result_array();
        }
        
        public function get_sub_ganres_by_user_type($user_type)
        {
            $data = $this->db->where('user_type',$user_type)->order_by('name')->get('ganres');
            return $data->result();
        }
        
        public function get_ganres_array_by_ganres_id_key($user_type)
        {
            $data = $this->get_sub_ganres_by_user_type($user_type);
            $res_array = [];
            foreach($data as $one)
            {
                $res_array[$one->id] = $one;
            }
            return $res_array;
        }
        
        public function get_user_types_array_by_user_type_id_key()
        {
            $data = $this->get_all_user_types();
            $res_array = [];
            foreach($data as $one)
            {
                $res_array[$one->id] = $one;
            }
            return $res_array;
        }
        
        
}