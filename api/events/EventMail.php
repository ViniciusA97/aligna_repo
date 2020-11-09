<?php

namespace Api\Events;

use Api\Abstracts\IEvent;
use Api\Abstracts\IMail;

class EventMail implements IEvent{

    private IMail $mailPresenter;

    function __construct(IMail $mail) {
        $this->mailPresenter = $mail;
    }

    public function handleEvent(){
        $this->mailPresenter->handleSendMail();
    }

}


?>