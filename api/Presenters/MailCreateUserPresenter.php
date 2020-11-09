<?php

namespace Api\Presenters;

use Api\Abstracts\IMail;
use Mail;


class MailCreateUserPresenter implements IMail{

    private $to;
    private $token;
    private $subject;
    private $view;
    private $content;

    function __construct($to, $token,$name ) {
        $this->to = $to;
        $this->token = $token;
        $this->content = [
            'token'=>$token,
            'link'=>$token,
            'name'=>$name
        ];
    }

    public function handleSendMail(){
        $to = $this->to;
        Mail::send(['html'=>'mail.mailMemberCreate'], $this->content, function($message) use($to)  {
           $message->to($to)->subject('Criação de conta na plataforma do aligna.');
           $message->from('ti@stalo.com','Stalo Software Studio');
        });

    }

}
?>