<?php

class main extends api
{
  protected function Reserve()
  {
    return 
    [
      "design" => "body",
      "script"  =>  "jquery.form"
    ];
  }

  protected function Home()
  {
    return
    [
      "design" => "isLoged",
      "data" => ["getSessionId" => LoadModule('api', 'register')->getSessionId()],
    ];
  }
}