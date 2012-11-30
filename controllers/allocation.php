<?php  
defined('_JEXEC') or die('Restricted access');  
   
jimport('joomla.application.component.controller');  
require_once ('components/com_allocation/models/databaseMgr.php');
   
class Controllerallocation extends JController {  
    function display() {  
        JRequest::setVar('view', 'principal'); 
        parent::display();  
    }
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
} 