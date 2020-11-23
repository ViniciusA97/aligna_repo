<?php

namespace Api\Presenters;

use Api\Abstracts\IMail;
use Mail;


class MailForgetPassword implements IMail{

    private $to;
    private $subject;
    private $view;
    private $content;

    function __construct($to, $token) {
        $this->to = $to;
        $this->token = $token;
        $this->content = [
            'link'=>$token
        ];
    }

    public function handleSendMail(){
        $to = $this->to;
        Mail::send(['html'=>'mail.mailMemberForgetPassord'], $this->content, function($message) use($to)  {
           $message->to($to)->subject('Recuperação de senha na plataforma do aligna.');
           $message->from('ti@stalo.com','Stalo Software Studio');
        });

    }

}
?>