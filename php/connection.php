<?php
/**
 * Created by PhpStorm.
 * User: Romero
 * Date: 12/05/2017
 * Time: 18:04
 */
function connect(){
    try {
            $user = 'root';
            $pass = '';
            $conn = new PDO('mysql:host=localhost;dbname=faculdadez', $user, $pass);
            $conn->exec("set names uft8");

        }
    catch
        (PDOException $e){
            echo 'Algo de errado aconteceu: ' . $e->getMessage();
        }
        return $conn;
    }

?>