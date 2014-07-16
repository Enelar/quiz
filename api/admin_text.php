<?php

class admin_text extends api
{
  private function dbWriteText()
  {
  }
  
  private function dbGetTexts()
  {
    return $tArr = db::Query("SELECT * FROM texts");
  }
  
	protected function Reserve()
	{
    $tArr = $this->dbGetTexts();
		return 
		[
		  "design"  =>  "admin_text",
      "result"  =>  "content",
      "data"  =>  ["tArr" =>  $tArr]
		];
	}   
}