<?php

class register extends api
{
  private function dbWriteUserInfo($POST)
  {    
    $res = 
      db::Query(
        "INSERT INTO users (name, occupation) values ($1, $2) returning id",
        [
          $POST["name"], 
          /*$_POST["surname"],*/ //TODO
          $POST["work"]
        ], true);
    phoxy_protected_assert($res, ["error" => "DB unavailable"]);
    return $res['id'];    
  }
  
  private function dbSetQuizId($quizId)
  {
    LoadModule('api', 'main')->startSession();
    $_SESSION['quizId'] = $quizId;
  }
  
  private function getSessionId()
  {
    LoadModule('api', 'main')->startSession();
    if ( !isset($_SESSION['quizId']) )
      return 0;
    
    return $_SESSION['quizId'];     
  }
      
  
  protected function submitRegForm()
  {    
    global $_POST;
    $quizId = $this->dbWriteUserInfo($_POST);
    
    $this->dbSetQuizId($quizId);
    die( IncludeModule('api', 'text')->Reserve());
  }
  
  protected function drawRegForm()
  {
    $quizId = $this->getSessionId();
    phoxy_protected_assert(!$quizId, ["error" => "Already registered"]);       
    return 
    [      
      "design"  => "register/registerForm",
      "result"  =>  "content",
    ];
  }
  
  protected function Reserve()
  {    
    return
    [
    "design" => "register/isLoged",
    "data" => ["sessionId" => $this->getSessionId()],
    ];
  }
}