<?php

class text extends api 
{
  public function getActiveTextId()
  {
    $activeTextId = db::Query("SELECT active_text_id FROM admin_table LIMIT 1", [], true);
    phoxy_protected_assert($activeTextId, ["error" => "DB unavailable"]);
    return $activeTextId['active_text_id'];
  }
  
  private function getText()
  {
    $activeTextId = $this->getActiveTextId();
    $text = db::Query("SELECT * FROM texts WHERE \"id\" = $1", [$activeTextId], true);
    phoxy_protected_assert($text, ["error" => "DB unavailable"]);
    return $text;
  }
    
  protected function isTextShown()
  {
    LoadModule('api', 'main')->startSession();
    phoxy_protected_assert($_SESSION['quizId'], ["error" => "Not registered"]);
    
    return
    [
      "design" => "text/chainLoader",
      "data" => ["isTextShown"  =>  isset($_SESSION['showText'])]
    ]; 
  }
  
  protected function closeText()
  {
    LoadModule('api', 'main')->startSession();
    phoxy_protected_assert($_SESSION['quizId'], ["error" => "Not registered"]);
    
    $_SESSION['showText'] = true;
    
    die( IncludeModule('api', 'questions')->Reserve());
  }
  
  protected function showText()
  {
    LoadModule('api', 'main')->startSession();
    phoxy_protected_assert($_SESSION['quizId'], ["error" => "Not registered"]);
    //phoxy_protected_assert(!$_SESSION['showText'], ["error" => "Already text shown"]);
    
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
    return $this->isTextShown();
  }
}