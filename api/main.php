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
      "design" => "register",
      "result"  =>  "content",      
    ];
  }
}