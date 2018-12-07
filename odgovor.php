<?php

$host = 'localhost';
$db = 'ibis';
$user = 'root';
$pass = '';
$charset = 'utf8';
$port = '3306';

$dsn = "mysql:host=".$host.";port=".$port.";dbname=".$db.";charset=".$charset;
$options = [
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES           =>false
];

try{
    $pdo = new PDO($dsn, $user, $pass, $options);
}catch(\PDOException $e){
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

//$stmt = $pdo->query('SELECT * FROM `contract`');
/*
$dateStartArray = date_parse((new DateTime(date("Y-m-d")))->sub(new DateInterval('P8D'))->format('Y-m-d'));
$dateEndArray = date_parse((new DateTime(date("Y-m-d")))->sub(new DateInterval('P1D'))->format('Y-m-d'));
*/

$SQL = null;
$start  = null;
$contract_id  = null;
$end =null ;
$input = null;
$field = null;


if(isset($_GET['start'])){
     $start = $_GET['start'];
     
}

if(isset($_GET['contract_id'])){
    $contract_id = intval($_GET['contract_id']);
}

if(isset($_GET['end'])){
    $end = $_GET['end'];
}


if(isset($_GET['input_search'])){
    $input = $_GET['input_search'];
}

if(isset($_GET['field'])){
    $field = $_GET['field'];
}




if($input!=null && $field!=null){
    $SQL = "SELECT * FROM `contract` WHERE ". $field . " LIKE '". $input ."%' ;";
}







if($start==1 || $start==7){
    $date_start = (new DateTime(date("Y-m-d")))->sub(new DateInterval('P1D'))->format('Y-m-d');
    $SQL = "SELECT value_1, value_2, value_3, value_4 , hour as value_5 FROM chart WHERE contract_id =  " .$contract_id. " and  date_at = '". $date_start ."' ;";
    if($start == 7){
        $date_end = (new DateTime(date("Y-m-d")))->sub(new DateInterval('P8D'))->format('Y-m-d');
        $SQL = "SELECT SUM(value_1) as value_1, SUM(value_2) as value_2, SUM(value_3) as value_3,  SUM(value_4) as value_4, date_at as value_5  FROM chart WHERE contract_id = ". $contract_id ." and  date_at BETWEEN '" . $date_end . "' and '" . $date_start . "' GROUP BY date_at ;";
        
    }
    
 }else if($start!=null && $end!=null){
    if($start != $end){
        $SQL = "SELECT SUM(value_1) as value_1, SUM(value_2) as value_2, SUM(value_3) as value_3,  SUM(value_4) as value_4, date_at as value_5  FROM chart WHERE contract_id = ". $contract_id ." and  date_at BETWEEN '" . $start . "' and '" . $end . "' GROUP BY date_at ;";
    }else{
        $SQL = "SELECT value_1, value_2, value_3, value_4 , hour as value_5 FROM chart WHERE contract_id =  " .$contract_id. " and  date_at = '". $start ."' ;";
    }
 }

 



$stmt = $pdo->prepare($SQL);
 $stmt->execute();
 $result = $stmt->fetchAll();

 

 

 

 $array_values = $result;
/*

$required_column = 'value_';
 ;
if(!isset($_GET['table']))
    if($_GET['table']==false)
 for($i = 1; $i<= count($result[0]); $i++) 
 $array_values[$required_column.$i] = array_column($result, $required_column.$i);
*/
 
 echo json_encode($array_values); exit(1);
 
 
 
 

