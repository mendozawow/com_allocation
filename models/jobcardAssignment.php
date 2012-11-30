<?php

Class JobcardAssignment{
public $jobcard_id;
public $vehicle_id;
public $timestamp;
public $allocator_id;
public $status;


    function __construct($item) {
    $this->jobcard_id = $item->jobcard_id;
    $this->vehicle_id = $item->vehicle_id;
    $this->timestamp = $item->timestamp;
    $this->allocator_id = $item->allocator_id;
    $this->status = $item->status;
    
    }
}

?>
