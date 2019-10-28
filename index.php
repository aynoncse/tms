<?php

$controller = isset($_GET['c'])? ucfirst($_GET['c']):'Dashboard';
$method 	= isset($_GET['m'])? $_GET['m']: 'home';

if (!empty($method) && !empty($controller)){

	include 'app/system/Controller.php';
	@include_once('app/Controllers/'.$controller.'.php');

	$obj='';
	if(class_exists($controller)){
		$obj = new $controller();
	}
	
	if(method_exists($obj,"$method")){
		$obj->$method();
		
	} else{ include 'views/404.php'; }
}
