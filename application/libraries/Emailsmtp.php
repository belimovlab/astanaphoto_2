<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Emailsmtp {

        protected $CI;
        protected  $data;
        protected $SPApiProxy;

        public function __construct()
        {
            $this->CI =& get_instance();
            require_once( './third_part/sendpulseInterface.php' );
            require_once( './third_part/sendpulse.php' );
        }

        public function send_test_email()
        {
            
            
            $email = array(
                'html'    => 'Your email content goes here',
                'text'    => 'Your email text version goes here',
                'subject' => 'Testing SendPulse API',
                'from'    => array(
                    'name'  => 'Администрация сервиса',
                    'email' => 'noreply@omskphoto.ru'
                ),
                'to'      => array(
                    array(
                        'name'  => 'Святослав Белимов',
                        'email' => 'sbelimov@gmail.com'
                    )
                )
            );
            
            var_dump( $this->SPApiProxy->smtpSendMail( $email ) );
        }
        
        
        public function send_email_html($to,$subject,$html_content)
        {
            $this->SPApiProxy = new SendpulseApi( '0ed2c31302827e4aa2350c5046a8a965', 'e3088fce634d31defb76663e233eb307', 'file' );
            
            $email = array(
                'html'    => $html_content,
                'text'    => '',
                'subject' => $subject,
                'from'    => array(
                    'name'  => MainSiteConfig::get_item('email_from_name'),
                    'email' => MainSiteConfig::get_item('noreply_email')
                ),
                'to'      => array(
                    array(
                        'name'  => '',
                        'email' => $to
                    )
                )
            );
            
            ob_start();
            $this->SPApiProxy->smtpSendMail( $email );
            $res =  ob_get_clean();

        }
}

/* End of file Auth.php */