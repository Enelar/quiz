<?php

class admin extends api
{
   private function dbGetData()
  {
    $txt = db::Query("SELECT * FROM texts");
    
    $quest = db::Query("SELECT * FROM questions");
    $answ = db::Query("SELECT * FROM answers");
    
    $text = array();
    foreach($txt as $key )
    {
      $text[$key["id"]] = array();
      //111
      $text[$key["id"]]["id"] = $key["id"];
      $text[$key["id"]]["title"] = $key["title"];
      $text[$key["id"]]["text"] = $key["data"];      
    }
    
    
    foreach($quest as $key )
    {                
      $text[$key["tId"]]["qArr"][$key["id"]] = array();
      $text[$key["tId"]]["qArr"][$key["id"]]["question"] = $key["data"];
      $text[$key["tId"]]["qArr"][$key["id"]]["qId"] = $key["id"];
      $text[$key["tId"]]["qArr"][$key["id"]]["isMulti"] = $key["isMulti"];
      $text[$key["tId"]]["qArr"][$key["id"]]["aArr"] = array();
    }
    
    foreach($answ as $key )
    {                
      $text[$key["tId"]]["qArr"][$key["questId"]]["aArr"][$key["id"]]["answ"] = $key["data"];//TODO check!!!!
      $text[$key["tId"]]["qArr"][$key["questId"]]["aArr"][$key["id"]]["id"] = $key["id"];//TODO check!!!!
    }
    
    return $text;
  }
	protected function Reserve()
	{
    $text = $this->dbGetData();
		return 
		[
		  "design"  =>  "admin",
      "result"  =>  "content",
      "data"  =>  ["tArr" =>  $text]
		];
	}  
} 