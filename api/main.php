<?php

class main extends api
{
  public function startSession()
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return;
    session_start();
  }
  
  protected function Reserve()
  {
    return 
    [
      "design"  =>  "body",
      "script"  =>  "jquery.form"
    ];
  }

  protected function Home()
  {
     die( IncludeModule('api', 'register')->Reserve());
  }
}