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
    return $res['id'];
    //TODO unite strings
  }
  
  private function dbSetQuizId($quizId)
  {
    session_start();
    $_SESSION['quizId'] = $quizId;
  }
  
  private function startSession()
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return;
    session_start();
  }
  
  protected function getSessionId()
  {
    $this->startSession();
    if ( !isset($_SESSION['quizId']) )
      return NULL;
    
    $quizId = $_SESSION['quizId'];
    return $quizId;
  }
  
  protected function log()
  {    
    $quizId = $this->dbWriteUserInfo();
    $this->dbSetQuizId($quizId);   
    
    $this->startSession();
    $_SESSION['quizId'] = $quizId;
    return 
    [
    ];
  }
  
  protected function Reserve()
  {
    $quizId = $this->getSessionId();    
    return 
    [      
      "design"  => "register",
      "result"  =>  "content",
      "data"  =>  ["quizId" =>  $quizId]
    ];    
  }
}