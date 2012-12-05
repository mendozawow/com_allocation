<?php

require_once ('components/com_allocation/models/databaseMgr.php');

class VehicleMgr {

    // Retorna un array de objetos cupones
    public function getVehicles($stmt, $params) {
        $databaseMgr = new DatabaseMgr();
        return $databaseMgr->loadObjects('Vehicle',$stmt,$params);

    }

    // Retorna un objeto cupon
    public function getVehicle($stmt, $params) {
        $set = $this->getVehicles($stmt, $params);
        return $set[0];
    }

    public function jGetVehicles($params) {
        $qParams = $params->params;
        $vehicles = $this->getVehicles('STMT_GET_VEHICLES', $qParams);
        return $vehicles;
    }
}

?>
