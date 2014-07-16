<?php

class text extends api 
{
  private function getText()
  {
    return $txt = '123';//TODO
  }
  protected function show()
  {
    $txt = $this->getText();
    return 
    [    
      "design"  =>  "text",
      "result"  =>  "content",
      "data"  =>  ["txt"  =>  $txt]
    ];
  }
}