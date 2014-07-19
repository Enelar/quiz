<?php

class ready extends api
{    
  protected function dbWriteAnswers()
  {
    LoadModule('api', 'register')->startSession();
    //var_dump($_SESSION['answers'][1]);
    
    if ( !isset( $_SESSION['answers'] ) )
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
    foreach(  $_SESSION['answers'] as $textId =>  $txtArr  )
    {
      foreach(  $txtArr as $questionId  =>  $answersArr  )
      { 
        foreach(  $answersArr as $key  =>  $answerId  )        
        {
          $res = 
            db::Query(
              "INSERT INTO users_answers (t_id, q_id, a_id, quiz_id) values ($1, $2, $3, $4) returning id",
              [
                $textId, 
                $questionId,
                $answerId,
                $_SESSION['quizId']
              ], true);
          phoxy_protected_assert($res, ["error" => "DB unavailable"]);
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