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
    //phoxy_protected_assert($_SESSION['quizId'], ["error" => "Already registered"]);
    $_SESSION['quizId'] = $quizId;
  }
  
  private function isRegistered()
  {
    LoadModule('api', 'main')->startSession();
    
    $quizId = 0;
    if ( isset($_SESSION['quizId']) )
      $quizId = $_SESSION['quizId'];
      
    return
    [
      "design" => "register/chainLoader",//isLoged
      "data" => ["sessionId" => $quizId],
    ];
  }
  
  protected function submitForm()
  {
    global $_POST;
    $quizId = $this->dbWriteUserInfo($_POST);
    
    $this->dbSetQuizId($quizId);
    die( IncludeModule('api', 'text')->Reserve());
  }
  
  protected function drawForm()
  {
    LoadModule('api', 'main')->startSession();
    global $_SESSION;
    //phoxy_protected_assert(!$_SESSION['quizId'], ["error" => "Already registered"]);
    return 
    [      
      "design"  => "register/registerForm",
      "result"  =>  "content",
    ];
  }
  
  protected function Reserve()
  {
    return $this->isRegistered();
  }
}