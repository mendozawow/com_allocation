<?php
require('directConfig.php' );
header('Content-Type: text/javascript');

// convert API config to Ext.Direct spec
$actions = array();
foreach($API as $aname=>&$a){
	$methods = array();
	foreach($a['methods'] as $mname=>&$m){
	    if (isset($m['len'])) {
		    $md = array(
			    'name'=>$mname,
			    'len'=>$m['len']
		    );
		} else {
		    $md = array(
		        'name'=>$mname,
		        'params'=>$m['params']
		    );
		}
		if(isset($m['formHandler']) && $m['formHandler']){
			$md['formHandler'] = true;
		}
		$methods[] = $md;
	}
	$actions[$aname] = $methods;
}

$cfg = array(
    'url'=>'index.php?option=com_allocation&view=main&controller=allocation&task=directRouter&tmpl=component&format=raw',
    'type'=>'remoting',
	'actions'=>$actions
);

echo 'Ext.ns("Ext.app"); Ext.app.REMOTING_API = ';

echo json_encode($cfg);
echo ';';
