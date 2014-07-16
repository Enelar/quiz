<?php
//TODO REWRITE!!!

class questions extends api
{
   private function dbGetData()
  {
    $txt = db::Query("SELECT * FROM texts");
    
    $quest = db::Query("SELECT * FROM questions");
    $answ = db::Query("SELECT * FROM answers");
    
    $text = array();
    foreach($text as $key )
    {
      $text[$key["id"]] = array();
      $text[$key["id"]]["id"] = $key["id"];
      $text[$key["id"]]["title"] = $key["title"];
      $text[$key["id"]]["text"] = $key["data"];
      $text[$key["id"]]["isMulti"] = $key["isMulti"];
      $text[$key["id"]]["answers"] = array();
    }
    
    foreach($answ as $key )
    {      
      array_push($question[$key["questId"]]["answers"], $key["data"]);
    }
    return $question;
  }
  protected function Reserve()
  {
    return 
    [
      "design"  =>  "admin",
      "result"  =>  "content",
      //"reset" =>  "#admin_text"
    ];
  }  
}