<?php

$connect = mysqli_connect("localhost", "root", "", "hms"); 

if(!$connect){
    die("Connection failed ". mysqli_connect_error());
}
