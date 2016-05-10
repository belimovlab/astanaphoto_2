<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    private $data;
    
    function __construct() {
        parent::__construct();
    }

    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function index()
    {
        redirect('/profile');
    }
    
    public function login()
    {
        if($this->accountlib->is_loggined())
        {
            redirect('/profile');
        }
        else
        {
            $this->data['header'] = $this->themelib->get_header('Авторизация в сервисе','page/forms');
            $this->data['footer'] = $this->themelib->get_footer();
            $this->load->view('/account/login',  $this->data);
        }
    }
    
    public function registration()
    {
        if($this->accountlib->is_loggined())
        {
            redirect('/profile');
        }
        else
        {
            $this->data['header']       = $this->themelib->get_header('Регистрация в сервисе','page/forms');
            $this->data['footer']       = $this->themelib->get_footer('account/registration');
            $this->data['ganres']       = $this->ganres_model->get_all_user_types();
            
            
            $this->data['email']        = $this->session->flashdata('email');
            $this->data['password']     = $this->session->flashdata('password');
            $this->data['re_password']  = $this->session->flashdata('re_password');
            $this->data['account']      = $this->session->flashdata('account');
            $this->data['first_name']   = $this->session->flashdata('first_name');
            $this->data['second_name']  = $this->session->flashdata('second_name');
            $this->data['birthday']     = $this->session->flashdata('birthday');
            $this->data['sex']          = $this->session->flashdata('sex');
            $this->data['error']        = $this->session->flashdata('error');
            
          
            $this->load->view('/account/registration',  $this->data);
        }
    }
    
    public function try_registration()
    {
        if($this->accountlib->is_loggined())
        {
            redirect('/profile');
        }
        else
        {
            $account     = $this->input->post('account');
            $email       = $this->input->post('email');
            $password    = $this->input->post('password');
            $re_password = $this->input->post('re_password');
            $first_name  = $this->input->post('first_name');
            $second_name = $this->input->post('second_name');
            $birthday    = $this->input->post('birthday');
            $sex         = $this->input->post('sex');
            
            $this->session->set_flashdata([
                    'account'     => $account,
                    'email'       => $email,
                    'password'    => $password,
                    're_password' => $re_password,
                    'first_name'  => $first_name,
                    'second_name' => $second_name,
                    'birthday'    => $birthday,
                    'sex'         => $sex
            ]);
          
            if(!$account || !$email || !$password || !$re_password || !$first_name || !$second_name || !$birthday || !$sex || ($password != $re_password))
            {
                $this->session->set_flashdata([
                    'error' => ErrorMessages::get_error('fill_all_fileds')
                ]);
                redirect('/account/registration');
            }
            else
            {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->session->set_flashdata([
                        'error' => ErrorMessages::get_error('email_valid')
                    ]);
                    redirect('/account/registration');
                }
                else
                {
                    if(!$this->validateDate($birthday))
                    {
                        $this->session->set_flashdata([
                            'error' => ErrorMessages::get_error('birthday')
                        ]);
                        redirect('/account/registration');
                    }
                    else
                    {
                        if(!$this->account_model->is_email_free($email))
                        {
                            $this->session->set_flashdata([
                                'error' => ErrorMessages::get_error('email_not_free')
                            ]);
                            redirect('/account/registration');
                        }
                        else 
                        {
                            $str = $this->account_model->set_new_account($email, $password, $account, $first_name, $second_name, $birthday, $sex);
                            $this->load->library('Emailsmtp');
                            $this->data['email'] = $email;
                            $this->data['code'] = $str;
                            $html = $this->load->view('email/noreply',  $this->data,TRUE);
                            $this->emailsmtp->send_email_html($email, 'Регистрация в сервисе', $html);
                            $this->session->set_userdata('active_code',$str);
                            
                            
                        }
                    }
                }
            }
            
        }
    }
    
    
 
 }
