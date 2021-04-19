<?php

class Flux{
    private string $url;


    function __construct(string $url=""){
        $this->url = $url;
    }

    public function  getUrl() {
      return $this->url;
    }

}


?>
