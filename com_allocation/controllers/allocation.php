<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once ('components/com_allocation/models/databaseMgr.php');
require_once ('components/com_allocation/models/bogusAction.php');
require ('components/com_allocation/models/directConfig.php');

class allocationController extends JController {
    function display() {
        JRequest::setVar('view', 'main');
        parent::display();
    }

    function directRouter(){
        $isForm = false;
        $isUpload = false;
        if (!isset($HTTP_RAW_POST_DATA)) {
            $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
        }
        if (isset($HTTP_RAW_POST_DATA)) {
            header('Content-Type: text/javascript');
            $data = json_decode($HTTP_RAW_POST_DATA);
        } else if (isset($_POST['extAction'])) { // form post
            $isForm = true;
            $isUpload = $_POST['extUpload'] == 'true';
            $data = new BogusAction();
            $data->action = $_POST['extAction'];
            $data->method = $_POST['extMethod'];
            $data->tid = isset($_POST['extTID']) ? $_POST['extTID'] : null; // not set for upload
            $data->data = array($_POST, $_FILES);
        } else {
            die('Invalid request.');
        }

        $response = null;
        if (is_array($data)) {
            $response = array();
            foreach ($data as $d) {
                $response[] = $this->doRpc($d);
            }
        } else {
            $response = $this->doRpc($data);
        }
        if ($isForm && $isUpload) {
            echo '<html><body><textarea>';
            echo json_encode($response);
            echo '</textarea></body></html>';
        } else {
            echo json_encode($response);
        }
    }



    function doRpc($cdata) {
        $DirectAPI = new DirectAPI();
        $API = $DirectAPI->api;
        try {
            if (!isset($API[$cdata->action])) {
                throw new Exception('Call to undefined action: ' . $cdata->action);
            }

            $action = $cdata->action;
            $a = $API[$action];

            $this->doAroundCalls($a['before'], $cdata);

            $method = $cdata->method;
            $mdef = $a['methods'][$method];
            if (!$mdef) {
                throw new Exception("Call to undefined method: $method on action $action");
            }
            $this->doAroundCalls($mdef['before'], $cdata);

            $r = array(
                'type' => 'rpc',
                'tid' => $cdata->tid,
                'action' => $action,
                'method' => $method
            );

            require_once("components/com_allocation/models/$action.php");
            $o = new $action();
            if (isset($mdef['len'])) {
                $params = isset($cdata->data) && is_array($cdata->data) ? $cdata->data : array();
            } else {
                $params = array($cdata->data);
            }

            $r['result'] = call_user_func_array(array($o, $method), $params);

            $this->doAroundCalls($mdef['after'], $cdata, $r);
            $this->doAroundCalls($a['after'], $cdata, $r);
        } catch (Exception $e) {
            $r['type'] = 'exception';
            $r['message'] = $e->getMessage();
            $r['where'] = $e->getTraceAsString();
        }
        return $r;
    }

    function doAroundCalls(&$fns, &$cdata, &$returnData = null) {
        if (!$fns) {
            return;
        }
        if (is_array($fns)) {
            foreach ($fns as $f) {
                $f($cdata, $returnData);
            }
        } else {
            $fns($cdata, $returnData);
        }
    }

    /*
    function RMVehicle()
    {
        $databaseMgr = new DatabaseMgr();
        $plate = JRequest::getVar('plate');
        $model = JRequest::getVar('model');
        $owner = JRequest::getVar('owner');
        $id = JRequest::getVar('vehicle_id');
        $status = JRequest::getVar('status');
        if($id)
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_UPDATE_VEHICLE_STATUS'),array($id,$status));
            $succes['status'] = true;
            $succes['message'] = "Estado de Vehiculo modificado exitosamente";
        }
        else
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_CREATE_VEHICLE'),array($plate,$model,$owner,$status));
            $succes['status'] = true;
            $succes['message'] = "Vehiculo creado exitosamente";
        }
    }
    function RMClient()
    {
        $id = JRequest::getVar("id");
        $name = JRequest::getVar("name");
        $address = JRequest::getVar("address");
        $databaseMgr = new DatabaseMgr();
        if($id)
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_UPDATE_CLIENT'),array($name,$address,$id));
                $succes['status'] = true;
                $succes['message'] = "Cliente actualizado exitosamente";
        }
        else
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_INSERT_NEW_CLIENT'),array($name,$address));
            $succes['status'] = true;
            $succes['message'] = "Cliente creado exitosamente";
        }
    }
    function RMJobcard()
    {
        $id = JRequest::getVar("id");
        $client_id = JRequest::getVar("client_id");
        $date = JRequest::getVar("date");
        $status = JRequest::getVar("status");
        $databaseMgr = new DatabaseMgr();
        if($id)
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_UPDATE_JOBCARD'),array($date,$status,$id));
            $succes['status'] = true;
            $succes['message'] = "Jobcard actualizada exitosamente";
        }
        else
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_INSERT_NEW_JOBCARD'),array($client_id,$date,$status));
            $succes['status'] = true;
            $succes['message'] = "Jobcard creada exitosamente";
        }

    }
    function RMEmployee()
    {
        $id = JRequest::getVar("user_id");
        $phone = JRequest::getVar("phone");
        $address = JRequest::getVar("address");
        $databaseMgr = new DatabaseMgr();
        if($id)
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_UPDATE_EMPLOYEE'),array($phone,$address,$id));
            $succes['status'] = true;
            $succes['message'] = "Empleado actualizado exitosamente";
        }
        else
        {
            $databaseMgr->queryStatement($databaseMgr->getStatement('STMT_INSERT_NEW_EMPLOYEE'),array($phone,$address));
            $succes['status'] = true;
            $succes['message'] = "Empleado creado exitosamente";
        }

    }
    function searchTecnics(){
        // HAY QUE VERIFICAR QUE NO TENGA LA CUENTA BLOQUEDA PARA QUE NO SEA UN TECNICO VIEJO
    }
    function blockAccount(){
        //Bloquear algun usuario para que no pueda acceder mas al sitio
    }
    function ModifyVehicleStatus(){
        //cambiar el estado de un vehiculo en caso de que se rompa, o vuelva nuevamente a ponerse en funcionamiento
        //En caso de que se rompa se deben desasignar el personal asociado y las jobcards y traspasarselas a otro auto.
        $status = JRequest::getVar("status");
        $id = JRequest::getVar("vehicle_id");
    }



  function allocationController(){
            $user	= new PortalUser();
            $action = JRequest::getString("action","");
            if(!$user->canAccess($action)){
                $success['status'] = "false";
                $success['message'] = "No tienes permitido realizar esta accion";
                echo json_encode($success);
                return;
            }
            switch($action)
            {
                case 'RMJobcard':{$this->RMJobcard();}
                case 'RMEmployee':{$this->RMEmployee();}
                case 'RMClient':{$this->RMClient();}
                case 'RMVehicle':{$this->RMVehicle();}
                case 'BlockAccount':{$this->blockAccount();}
                case 'AssignVehicle':{}
                case 'AssignJobcard':{}
                case 'ModifyVehicleStatus':{
                    $this->ModifyVehicleStatus();
                }
            }

  }
     *
     */
}