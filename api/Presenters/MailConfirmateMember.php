<?php

namespace Api\Presenters;

use Api\Abstracts\IMail;
use Mail;


class MailConfirmateMember implements IMail{

    private $to;
    private $content;

    function __construct($to,$name) {
        $this->to = $to;
        $this->content = [
            'name'=>$name
        ];
    }

    public function handleSendMail(){
        $to = $this->to;
        Mail::send(['html'=>'mail.mailMemberConfirm'], $this->content, function($message) use($to)  {
           $message->to($to)->subject('Confirmação de conta na plataforma do aligna.');
           $message->from('ti@stalo.com','Stalo Software Studio');
        });

    }

}
?>