<?php

Class VehicleAssignment{
public $timestamp;
public $vehicle_id;
public $employee_id;


    function __construct($item) {
    $this->timestamp = $item->timestamp;
    $this->vehicle_id = $item->vehicle_id;
    $this->employee_id = $item->employee_id;
    
    }
}

?>
