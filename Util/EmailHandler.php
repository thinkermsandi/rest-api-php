<?php

namespace Api\Util;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Description of Email
 *
 * @author thinkermsandi
 */
class EmailHandler {
    
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer();
        $this->setUp();
    }
    
    private function setUp(){
        $this->mailer->isSMTP();
        $this->mailer->isHTML(true);
        $this->mailer->Host = getenv('REST_API_PHP_EMAIL_SENDER_HOST');  // Specify main and backup SMTP servers
        $this->mailer->SMTPAuth = true; // Enable SMTP authentication
        $this->mailer->SMTPSecure = 'ssl'; // Enable SSL encryption, `tls` also accepted
        $this->mailer->Username = getenv('REST_API_PHP_EMAIL_SENDER_ADDRESS'); // SMTP username
        $this->mailer->Password = getenv('REST_API_PHP_EMAIL_SENDER_PASSWORD');
        $this->mailer->Port = getenv('REST_API_PHP_EMAIL_SENDER_PORT');
        $this->mailer->setFrom(getenv('REST_API_PHP_EMAIL_SENDER_ADDRESS'), getenv('REST_API_PHP_EMAIL_SENDER_NAME'));
        $this->mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

    }

    public function addAttachment($filename){
        if($this->mailer){
            if($this->mailer->addAttachment($filename)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    public function send($recieverAddress, $recieverName, $subject, $body) {
		
        if($this->mailer){
            $this->mailer->addAddress($recieverAddress, $recieverName);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
			
            if($this->mailer->send()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            false;
        }
    }
    
}
