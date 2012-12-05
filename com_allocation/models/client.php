<?php

Class Client{
public $id;
public $name;
public $address;


    function __construct($item) {
    $this->address = $item->address;
    $this->name = $item->name;
    $this->id = $item->id;
    
    }
}
?>
