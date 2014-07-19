<?php

class questions extends api
{     
  protected function saveAnswer()
  {
    LoadModule('api', 'register')->startSession();
    
    global $_POST;
    if ( !isset( $_SESSION['answers'] ) )
      $_SESSION['answers'] = array();
      
    $questionId = $_POST["questionId"];    
    $textId = LoadModule('api', 'text')->getTextId();
    
    // ???
    foreach(  $_POST as $answerId =>  $isChecked  )
    {
      if  ( substr($answerId, 0, 4) == 'answ')
        $_SESSION['answers'][$textId][$questionId]["$answerId"] = $isChecked;
    }      

    return 
    [
      "design"  =>  "questions",
      "result"  =>  "content",
      "data"  =>  ["textId" =>  $tId,
                          "qId" =>  $qId]
    ]; 
    return $this->Reserve($questionId);
  }  
  
  private function dbGetNextQuestion($prevQuestionId)
  {
    $textId = LoadModule('api', 'text')->getTextId();
    $question = db::Query("SELECT * FROM questions WHERE \"tId\" = $1 AND \"id\" > $2 LIMIT 1", [$textId, $prevQuestionId], true);
    //phoxy_protected_assert($question, ["error" => "DB unavailable"]);
    return $question;   
  }
  
  private function dbGetAnswers($questionId)
  { 
    $textId = LoadModule('api', 'text')->getTextId();
    $answers = db::Query("SELECT * FROM answers WHERE \"questId\" = $1", [$questionId]);    
    //phoxy_protected_assert($answers, ["error" => "DB unavailable"]);
    return $answers;
  }
  
  /*
  protected function dbDrawQuestion($qId = 0)
  {
    $q = $this->dbGetQuestion($textId, $qId);
    $a = $this->dbGetAnswers($textId, $qId);
    return 
    [
      "design"  =>  "isQuestExist",
      "result"  =>  "content",
      "data"  =>  ["q" =>  $q,
                          "a" =>  $a,
                          "t" =>  $textId]
    ];
  }
  */
  
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
      "design"  =>  "isQuestExist",
      "result"  =>  "content",
      "data"  =>  ["question" =>  $q,
                          "answers" =>  $a,]
    ];
  }  
}