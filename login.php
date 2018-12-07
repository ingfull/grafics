<!DOCTYPE html>
<?php
session_start();


require_once($_SERVER['DOCUMENT_ROOT'] ."/Ibis-Instruments/DatabaseConfiguration.php");
require_once($_SERVER['DOCUMENT_ROOT'] ."/Ibis-Instruments/DatabaseConnection.php");







if(isset($_GET['logout'])){
    session_destroy();
}

if(isset($_SESSION["username"])){
    header("Location: http://localhost:8080/Ibis-Instruments/");
    die();
}


$errors = [];
if(isset($_GET['check'])){
    if(isset($_GET['password'])){
        if($_GET['password']=='' || $_GET['password']==null ){
           
            $errors["password"] = "missed Password"; 
        }else{
            $password = $_GET['password'];
            
        }
        
    
    }


    if(isset( $_GET['username'])){
        if($_GET['username'] == null || $_GET['username'] == ''){
            $errors["password"] = "missed userbane"; 

        }else{
            $username = $_GET['username'];
        }
       
    }
    
    if(count($errors) == 0){
        $config = new DatabaseConfiguration();
        $connection = new DatabaseConnection($config);
        $pdo = $connection->getConnection();


        $SQL = "SELECT *  FROM `user` WHERE `username` =  '" .$username. "' and  `password` = '". $password ."' ;";

       

        $stmt = $pdo->prepare($SQL);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(count($result)!=0){
            var_dump($result[0]["username"]);
            $_SESSION["username"] = $result[0]["username"];
            header("Location: http://localhost:8080/Ibis-Instruments/");
            die();
        }
        


    }

}
    
   
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/custom.css">
    </head>
    <body>
        <div id="login">
        <div class="container" style="" >
            <div id="login-form" class="row">
            <div class="col-md-4"></div>
                <div class="col-md-4">
                <form method="get" action="http://localhost:8080/Ibis-Instruments/login.php" >
                    <input type="text" class="control-form form-input" name="username" placeholder="Username" />
                    <input type="password" class="control-form form-input" name="password" placeholder="Password" />
                    <input type="hidden" value="check" name="check" />
                    <button class="btn btn-primary form-input">Login</button>
                </form>
                </div> 
                <div class="col-md-4"></div>
            </div>
            </div>
        <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>