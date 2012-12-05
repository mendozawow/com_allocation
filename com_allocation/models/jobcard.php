<?php

Class Jobcard{
public $id;
public $client_id;
public $date;
public $status;


    function __construct($item) {
    $this->date = $item->date;
    $this->client_id = $item->client_id;
    $this->id = $item->id;
    $this->status = $item->status;
    
    }
}
?>
