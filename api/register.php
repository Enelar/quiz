<?php

class register extends api
{
  private function dbWriteUserInfo()
  {
    global $_POST;
    return $quizId = db::Query("INSERT INTO users (name, occupation) values ($1, $2) returning id", [$_POST["name"], /*$_POST["surname"],*/ $_POST["work"]]);
    //TODO unite strings
  }
  
  private function dbSetQuizId($quizId)
  {
    session_start();
    $_SESSION['quizId'] = $quizId;
  }
  
  protected function log()
  {
    $quizId = $this->dbWriteUserInfo();
    $this->dbSetQuizId($quizId);   
    
    return 
    [      
      "reset" => "#text/show"
    ];
  }
}