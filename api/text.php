<?php

class text extends api 
{   
  private function getText()
  {
    return $txt = '123';//TODO
  }
    
  protected function isTextShown()
  {
    LoadModule('api', 'main')->startSession();
    
    if ( !isset($_SESSION['showText']) )
      return false;
        
    return true;
  }
  
  protected function closeText()
  {
    LoadModule('api', 'main')->startSession();
    $_SESSION['showText'] = true;
    
    die( IncludeModule('api', 'questions')->Reserve());
  }
  
  protected function showText()
  {           
    $txt = $this->getText();
    return 
    [
      "design"  =>  "text/showText",
      "result"  =>  "content",
      "data"  =>  ["txt"  =>  $txt]
    ];
  }
  
  protected function Reserve()
  {         
    return
    [
      "design" => "text/isTextShown",
      "data" => ["isTextShown"  =>  $this->isTextShown()]
    ];
  }
}