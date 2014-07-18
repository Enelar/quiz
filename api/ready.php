<?php

class ready extends api
{
  private function startSession()
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return;
    session_start();
  }  
  
  protected function dbWriteAnswers()
  {
    $this->startSession();   
    
    if ( !isset( $_SESSION['answ'] ) )
    {
    //TODO
      return 
      [
        "error" =>  "enable coockies, please"
      ];
    }

    if ( !isset( $_SESSION['quizId'] ) )
    {
    //TODO
      return 
      [
        "error" =>  "you not logged"
      ];
    }
   
    foreach(  $_SESSION['answ'] as $tId =>  $tArr  )
    {
      foreach(  $tArr as $qId  =>  $aArr  )
      { 
        foreach(  $aArr as $aId  =>  $val  )        
        {
          $res = 
            db::Query(
              "INSERT INTO users_answers (t_id, q_id, a_id, quiz_id) values ($1, $2, $3, $4) returning id",
              [
                $tId, 
                $qId,
                $aId,
                $_SESSION['quizId']
              ], true);
        }        
      }
    }
          
  }
  protected function Reserve()
  {
    $this->dbWriteAnswers();
    return
    [
      "design" => "ready",
      "result" => "content"
    ];  
  }

}