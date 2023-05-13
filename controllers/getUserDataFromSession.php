<?php

session_start();

$name = $_SESSION["name"];
$image =  $_SESSION['image'];

echo json_encode(["name"=>$name,"image"=>$image]);