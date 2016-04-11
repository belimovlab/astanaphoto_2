<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_model extends CI_Model {

        private $data;

        public function __construct()
        {
                parent::__construct();
        }

        public function check_post_data()
        {
            $email       = $this->input->post('email');
            $password    = $this->input->post('password');
            $repassword  = $this->input->post('repassword');
            $first_name  = $this->input->post('first_name');
            $second_name = $this->input->post('second_name');
            $birthday    = $this->input->post('birthday');
            $account     = $this->input->post('account');
            if(!$email ||  !$password || !$repassword || !$first_name ||  !$second_name || !$birthday || !$account)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        
        
        public function check_email_is_free($email)
        {
            $is_user = $this->db->get_where('account',array(
                'email'=>$email
            ))->row();
            
            if($is_user->id)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        
        public function add_user($data)
        {
            $active_code = md5(MainSiteConfig::get_item('encryption_key').$data['email'].  mktime());
            
            
            $this->db->insert('account',array(
                'id'          =>'',
                'create_date' => date('Y-m-d H:i:s'),
                'email'       => strtolower($data['email']),
                'password'    => md5(MainSiteConfig::get_item('encryption_key').$data['password']),
                'is_active'   =>0,
                'is_blocked'  =>0,
                'active_code' =>$active_code
            ));
            
            
            $user_account = $this->db->get_where('account',array(
                'email'=>$data['email']
            ))->row();

            if($user_account->id)
            {
                $this->db->insert('profile',array(
                    'id'           =>'',
                    'user_id'      =>$user_account->id,
                    'first_name'   =>$data['first_name'],
                    'second_name'  =>$data['second_name'],
                    'birthday'     =>date('Y-m-d H:i:s',  strtotime($data['birthday'])),
                    'sex'          =>$data['sex'],
                    'account_type' => $data['account']
                ));
                return array(
                    'status'       => 'success',
                    'error'        => 'Регистрация завершена!',
                    'active_code'  => $active_code,
                    'email'        => $user_account->email
                );
            }
            else
            {
                return array(
                    'status'=>'error',
                    'error' => 'Регистрация не завершена. Попробуйте позже!'
                );
            }
            
        }


}