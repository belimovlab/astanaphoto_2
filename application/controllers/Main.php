<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    private $data;
    
    function __construct() {
        parent::__construct();
        if(!$this->accountlib->is_loggined())
        {
            redirect('/account/login');
        }
    }


    public function index()
    {
        $this->data['header'] = $this->themelib->get_header('Главная страница','cc/ee,bb/aa');
        $this->data['footer'] = $this->themelib->get_footer();
        $this->load->view('welcome_message',  $this->data);
    }
    
 }
