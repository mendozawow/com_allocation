<?php
require_once ('components/com_allocation/models/databaseMgr.php');
Class PortalUser {
    public $id;
    public $userGroups;
    
    function __construct() 
    {
        $user = JFactory::getUser();
        $this->id = $user->id;
        
    }
    public function inGroup($int)
    {
        $ingroup = false;
        if (!$this->userGroups)
        {
            $this->userGroups = JAccess::getGroupsByUser($this->id,true);
        }
        for($i = 0;$i < count($this->userGroups);$i++)
        {
            if($this->userGroups[$i] == $int)
            {
                $ingroup = true;
            }
        }
        return $ingroup;
    }

    public function canAccess($string){
    $arrayAccess = $this->arrayAccess();
    $permissions = $arrayAccess[$string];
    $canAccess = false;
    if($permissions){
        for($i = 0;$i < count($permissions);$i++)
        {
            if($this->inGroup($permissions[$i])){
                $canAccess = true;
            }
        }
    }
    return $canAccess;
    }
    function arrayAccess(){
    $arrayAccess = array();
    $arrayAccess['RMJobcard'] = array();
    $arrayAccess['ABMEmployee'] = array();
    $arrayAccess['RMVehicle'] = array();
    $arrayAccess['RMClient'] = array();
    $arrayAccess['AssignVehicle'] = array();
    $arrayAccess['AssignJobcard'] = array();
    $arrayAccess['ModifyVehicleStatus'] = array();
    $arrayAccess['BlockAccount'] = array();
    
    //etc etc...
    return $arrayAccess;
    }
}

?>
