<?php

class DirectAPI{
    public $api;

    function __construct() {
        $this->api = array(
            'VehicleMgr'=>array(
                'methods'=>array(
                    'jGetVehicles'=>array(
                        'len'=>1
                    )
                )
            )
        );
    }
}
?>