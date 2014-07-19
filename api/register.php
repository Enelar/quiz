<?php

class register extends api
{
  private function dbWriteUserInfo()
  {
    global $_POST;
    $res = 
      db::Query(
        "INSERT INTO users (name, occupation) values ($1, $2) returning id",
        [
          $_POST["name"], 
          /*$_POST["surname"],*/ 
          $_POST["work"]
        ], true);
    phoxy_protected_assert($res, ["error" => "DB unavailable"]);
    return $res['id'];    
  }
  
  private function dbSetQuizId($quizId)
  {
    $this->startSession();
    $_SESSION['quizId'] = $quizId;
  }
  
  private function getSessionId()
  {
    $this->startSession();
    if ( !isset($_SESSION['quizId']) )
      return 0;
    
    return $_SESSION['quizId'];     
  }
  
  protected function startSession()
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return;
    session_start();
  }  
  
  protected function reg()
  {    
    $quizId = $this->dbWriteUserInfo();
    
    $this->dbSetQuizId($quizId);
    return 
    [
      "reset" =>  "#text"
    ];
  }
  
  protected function form()
  {
    //$quizId = $this->getSessionId();
    //phoxy_protected_assert(!$quizId, ["error" => "Already registered"]);       
    return 
    [      
      "design"  => "register",
      "result"  =>  "content",
    ];
  }
  
  protected function Reserve()
  {    
    return
    [
    "design" => "isLoged",
    "data" => ["getSessionId" => $this->getSessionId()],
    ];
  }
}