<?php
//TODO REWRITE!!!

class questions extends api
{

  private function startSession()
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return;
    session_start();
  }  
  
  protected function saveAnswer()
  {
    $this->startSession();
    
    global $_POST;
    if ( !isset( $_SESSION['answ'] ) )
      $_SESSION['answ'] = array();
      
    $qId = $_POST["qId"];    
    $tId = $_POST["tId"];
    
    if($_POST["isMulti"] == 't')
    {
      foreach(  $_POST as $aId =>  $isChecked  )
      {
        if (  $isChecked == "Yes" )
          $_SESSION['answ'][$tId][$qId]["$aId"] = $aId;        
      }      
    }
    else
    {
      $aId = $_POST["$qId"];
      $_SESSION['answ'][$tId][$qId]["$aId"] = $aId;
    }
    
    $qId = $qId + 1;
    
    return 
    [
      "design"  =>  "questions",
      "result"  =>  "content",
      "data"  =>  ["textId" =>  $tId,
                          "qId" =>  $qId]
    ];
     /*
    $res = 
      db::Query(
        "INSERT INTO users (name, occupation) values ($1, $2) returning id",
        [
          $_POST["name"], 
          /*$_POST["surname"],*//*
          $_POST["work"]
        ], true);
    
    if ( !isset( $_SESSION['answ'] ) )
      $_SESSION['answ'] = array();
    
    $_SESSION['answ'][$qId] = $aId;   
    */
  }
  
  private function dbGetData($textId, $currQId)
  {   
    
    /*
    //$this->startSession();
    $textId = 2;
    $quest = db::Query("SELECT * FROM questions WHERE \"tId\" = $textId");
    $answ = db::Query("SELECT * FROM answers WHERE \"tId\" = $textId");
    
    $question = array();
    foreach($quest as $key )
    {
      $question[$key["id"]] = array();
      $question[$key["id"]]["id"] = $key["id"];
      $question[$key["id"]]["question"] = $key["data"];
      $question[$key["id"]]["isMulti"] = $key["isMulti"];
      $question[$key["id"]]["answers"] = array();
    }
    
    foreach($answ as $key )
    {      
      $question[$key["questId"]]["answers"][$key['id']] = $key["data"];
    }
    $question["currId"] = 1;
    return $question;
    */
  }
  
  protected function dbGetQuestion($textId, $currQId)
  {
    $quest = db::Query("SELECT * FROM questions WHERE \"tId\" = $1 AND \"id\" = $2", [$textId, $currQId], true);
    return $quest;
    /*
    $question = array();
    foreach($quest as $key )
    {
      $question[$key["id"]] = array();
      $question[$key["id"]]["id"] = $key["id"];
      $question[$key["id"]]["question"] = $key["data"];
      $question[$key["id"]]["isMulti"] = $key["isMulti"];
      $question[$key["id"]]["answers"] = array();
    }
    */
  }
  
  protected function dbGetAnswers($textId, $qId)
  {    
    $answ = db::Query("SELECT * FROM answers WHERE \"tId\" = $1 AND \"questId\" = $2", [$textId, $qId]);    
    return $answ;
  }
  
  protected function dbDrawQuestion($textId, $qId)
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
  
  protected function Reserve($qId = 1)
  {    
    $tId = 1;//TODO    
    return 
    [
      "design"  =>  "questions",
      "result"  =>  "content",
      "data"  =>  ["textId" =>  $tId,
                          "qId" =>  $qId]
    ];
  }  
}