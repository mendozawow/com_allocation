<?php

/**
 * Mysqli prepeared statement helper
 *
 * @author Adam Steven Docherty
 * @license GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class DatabaseMgr {

    public $DB_HOST;
    public $DB_USER;
    public $DB_PASS;
    public $DB_NAME;
    public $DB_PRFX;

    public function __construct() {
        //set up constants from J! config
        $JConfig = JFactory::getConfig();
        $this->DB_HOST = $JConfig->get('host');
        $this->DB_USER = $JConfig->get('user');
        $this->DB_PASS = $JConfig->get('password');
        $this->DB_NAME = $JConfig->get('db');
        $this->DB_PRFX = $JConfig->get('dbprefix');
    }

    function getStatement($stmt) {
        switch ($stmt) { 
            case 'STMT_GET_USERGROUPS':
                return "SELECT group_id FROM #__user_usergroup_map WHERE user_id = ?";
            case 'STMT_UPDATE_CLIENT':
                return "UPDATE #__allocation_client SET name = ?, address = ? WHERE id = ?";
            case 'STMT_INSERT_NEW_CLIENT':
                return "INSERT INTO #__allocation_client (`name`, `address`) VALUES (?,?) ";
            case 'STMT_UPDATE_JOBCARD':
                return "UPDATE #__allocation_jobcard SET date = ? , status = ? WHERE id = ? ";
            case'STMT_INSERT_NEW_JOBCARD':
                return "INSERT INTO #__allocation_jobcard (`client_id`,`date`,`status`) VALUES (?,?,?)";
            case 'STMT_CREATE_VEHICLE':
                return "INSERT INTO #__allocation_vehicle (`plate`,`model`,`owner`,`status`) VALUES (? , ? , ? , ?)";
            case'STMT_UPDATE_EMPLOYEE':
                return "UPDATE #__allocation_employee SET phone = ? , address = ? WHERE user_id = ? ";
            case 'STMT_INSERT_NEW_EMPLOYEE':
                return "INSERT INTO #__allocation_employee (`phone`,`address`) VALUES (?,?)";
            default:
                return;
        }
    }

    function queryStatement($sql, $params = false) {

        //connect to the db
        $mysqli = new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASS, $this->DB_NAME);

        // Character set UTF-8
        $mysqli->set_charset("utf8");

        //initialise prepared statement
        $stmt = $mysqli->stmt_init();

        //populate db prefix
        $sql = str_replace('#__', $this->DB_PRFX, $sql);

        //popluate prepare method with var from api call
        $stmt->prepare($sql);

        //bind the params, this required that we reference each var again
        //due to the fact that the bind_param method will only accept
        //referenced variables
        if ($params) {
            array_unshift($params, str_repeat('s', count($params)));
            $stmt_params = array();

            foreach ($params as $k => &$value) {
                $stmt_params[$k] = &$value;
            }

            call_user_func_array(array($stmt, 'bind_param'), $stmt_params);
        }

        $stmt->execute();
        $stmt->store_result(); /* transfer result set from the prepared statement */

        //see if we are dealing with results if we are not there is no need to process results
        //and it is likely we are dealing with an INSERT UPDATE or DELETE
        if ($stmt->num_rows) {

            //gather meta data from our bound statement
            //this will allow us to bind all our results automatically
            $data = $stmt->result_metadata();
            $count = 0;
            while ($field = $data->fetch_field()) {
                $fields[] = $field->name;
                $fieldnames[$count] = &$array[$field->name];
                $count++;
            }

            //now we bind the results
            call_user_func_array(array($stmt, 'bind_result'), $fieldnames);

            $return_array = array();

            //fetch our results as an associative array from the bound variables
            //initialised above
            while ($stmt->fetch()) {
                foreach ($fieldnames as $key => $value) {
                    $result[$fields[$key]] = $value;
                }
                $return_array[] = $this->arrayToObject($result);
            }

            $stmt->free_result(); /* free result set from buffer */

            //lets see if there is an insert id to return
        } else if ($stmt->insert_id) {
            $return_array = $stmt->insert_id;
            //if there is no insert id we simple return affected rows
        } else if ($stmt->affected_rows) {
            $return_array = $stmt->affected_rows;
        }

        if ($stmt->error) {
            $return_array = $stmt->error;
        }

        $stmt->close(); /* close statement and connection */

        $mysqli->kill($mysqli->thread_id);
        $mysqli->close(); /* closes connection */

        return $return_array;
    }

    function arrayToObject($array) {
        $obj = new stdClass();
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $v = $this->arrayToObject($v);
            }
            $obj->{strtolower($k)} = $v;
        }
        return $obj;
    }

    public function loadObjects($type, $stmt, $params) {
        $resultSet = $this->queryStatement($this->getStatement($stmt), $params);

        if (!$resultSet)
            return NULL;

        $objectSet = Array();
        foreach ($resultSet as $result) {
            $object = new $type($result);
            $objectSet[] = $object;
        }
        return $objectSet;
    }

}