<?php

Class Vehicle{
public $id;
public $plate;
public $model;
public $owner;
public $status;


    function __construct($item) {
        $this->id = $item->id;
        $this->plate = $item->plate;
        $this->model = $item->model;
        $this->owner = $item->owner;
        $this->status = $item->status;
    }
}

?>
