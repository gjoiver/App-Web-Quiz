<?php

//Abrir conexion a la DB
function connect($db)
{
    try{
        $conn = new PDO("mysql:host={$db['host']}; dbname={$db['db']}; charset=utf8", $db['username'], $db['password']);
         
        // set the PDO error mode to conexion 
        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $exception){
        exit($exception->getMessage());
    }
}


//obtener parametros para updates

function getparams($input)
{
    $filterParams = [];
    foreach($input as $param => $value)
    {
        $filterParams[] = "$param =:$param";
    }
    return implode(", ", $filterParams);
}

//Asociar todos los parametros a un sql

function bindAllvalues($statement, $params)
{
    foreach($params as $param => $value)
    {
        $statement->bindvalues(':'.$param, $value);
    }
    return $statement;
}
function disconnect ( $pdo, $stmt ) {
    global $pdo, $stmt;
    $stmt = null;
    $pdo = null;
 }
?>