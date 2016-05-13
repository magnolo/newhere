<?php

namespace App\Logic\Mailers;

abstract class Mailer {
    protected $beautymail;

    public function __construct(){
      $this->beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
    }

    public function sendTo($email, $name = '', $subject, $fromEmail, $view, $data = [])
    {
      //  dd($email, $name, $subject, $fromEmail, $view, $data);


      $this->beautymail->queue($view, $data, function($message) use ($email, $name, $subject, $fromEmail)
      {
          $message
              ->from('info@newhere.at')
              ->to($email,$name)
              ->subject($subject);
      });
    }
    public function view($view, $data){
      return $this->beautymail->view($view,$data);
    }

}
