<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Account_model extends CI_Model {

        

    public function __construct()
    {
            parent::__construct();
    }

    private function randomPassword() {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    
    public function is_email_free($email)
    {
        return $this->db->get_where('account',array(
            'email' => strtolower($email)
        ))->row()->id ? false :true;
    }

    public function set_new_account($email,$password,$account,$first_name, $second_name,$birthday,$sex)
    {
        $rnd_str = $this->randomPassword();
        $this->db->insert('account',array(
            'id'          => '',
            'create_date' => date('Y-m-d H:i:s'),
            'email'       => strtolower($email),
            'password'    =>  md5(MainSiteConfig::get_item('encryption_key').$password),
            'is_active'   => 0,
            'is_blocked'  => 0,
            'active_code' => $rnd_str
        ));
        
        $user_id = $this->db->get_where('account',array('email'=>$email))->row()->id;
        
        
        $this->db->insert('profile',array(
            'id'=>'',
            'user_id' => $user_id,
            'account_type' => $account,
            'first_name' => $first_name,
            'second_name' =>  $second_name,
            'birthday' => date('Y-m-d H:i:s',  strtotime($birthday)),
            'sex' => $sex
        ));
        
        
        return $rnd_str;
    }
        
        
}