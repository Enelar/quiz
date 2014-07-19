<?php

class questions extends api
{     
  protected function saveAnswer()
  {
    LoadModule('api', 'main')->startSession();    
    global $_POST;
    global $_SESSION;  
    $questionId = $_POST["questionId"];    
    $textId = LoadModule('api', 'main')->getActiveTextId();
    
    phoxy_protected_assert($_SESSION['quizId'], ["error" => "Not registered"]); 
    $quizId = $_SESSION['quizId'];
    
    // ???
    foreach(  $_POST as $answer =>  $answerId  )
    {
      if  ( substr($answer, 0, 4) == 'answ')
      {
        //$answerId = substr($answer, 4, 1);
        $res = 
            db::Query(
              "INSERT INTO users_answers (t_id, q_id, a_id, quiz_id) values ($1, $2, $3, $4) returning id",
              [
                $textId, 
                $questionId,
                $answerId,
                $quizId
              ], true);
        phoxy_protected_assert($res, ["error" => "DB unavailable"]);
      }
    }      

    return $this->Reserve($questionId);
    
    //IncludeModule('api', 'questions')->Reserve());    
  }  
  
  private function dbGetNextQuestion($prevQuestionId)
  {
    $textId = LoadModule('api', 'main')->getActiveTextId();
    $question = db::Query("SELECT * FROM questions WHERE \"tId\" = $1 AND \"id\" > $2 LIMIT 1", [$textId, $prevQuestionId], true);
    //phoxy_protected_assert($question, ["error" => "DB unavailable"]); //possible
    return $question;   
  }
  
  private function dbGetAnswers($questionId)
  { 
    $textId = LoadModule('api', 'main')->getActiveTextId();
    $answers = db::Query("SELECT * FROM answers WHERE \"questId\" = $1", [$questionId]);    
    //phoxy_protected_assert($answers, ["error" => "DB unavailable"]); //possible
    return $answers;
  }
  
  protected function Reserve($prevQuestionId = 0)
  {    
    // TODO: Check question id straight
    $q = $this->dbGetNextQuestion($prevQuestionId);
    if (isset($q['id']))
      $a = $this->dbGetAnswers($q['id']);
    else
      $a = NULL;
    return 
    [
      "design"  =>  "questions/isQuestExist",
      "result"  =>  "content",
      "data"  =>  ["question" =>  $q,
                          "answers" =>  $a,]
    ];
  }  
}