<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	var $data;
        
	public function index()
	{
            $this->data['header'] = $this->themelib->get_header('Главная страница');
            $this->data['footer'] = $this->themelib->get_footer();
            $this->load->view('welcome_message',  $this->data);
	}
}
