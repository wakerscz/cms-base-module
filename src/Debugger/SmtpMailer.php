<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Debugger;


use Nette\Mail\IMailer;
use Nette\Mail\Message;


class SmtpMailer implements IMailer
{
    /**
     * @var array
     */
    protected $smtp;


    /**
     * SmtpMailer constructor.
     * @param array $smtp
     */
    public function __construct(array $smtp)
    {
        $this->smtp = $smtp['exceptions'];
    }


    /**
     * Sends email.
     * @param Message $message
     * @return void
     */
    public function send(Message $message) : void
    {
        $sender = $this->smtp['sender'];
        $recipients = is_array($sender['to']) ? $sender['to'] : [$sender['to']];

        $message->setFrom($sender['email'], $sender['name']);

        foreach ($recipients as $to)
        {
            $message->addTo($to);
        }

        $mailer = new \Nette\Mail\SmtpMailer($this->smtp['config']);
        $mailer->send($message);
    }
}