<?php
//This file contains code that is common to multiple php files related to the online membership application 
//Initialiaze variables
    $mbr_name = $mbr_addr = $mbr_apt = $mbr_pobox = $mbr_city = $mbr_state = $mbr_zip = $mbr_lvl = $mbr_type = $mbr_length = "";

    //Collect POST data
    $mbr_name = $_POST["mbr_name"];
    $mbr_addr = $_POST["mbr_addr"];
    $mbr_apt = $_POST["mbr_apt"];
    $mbr_pobox = $_POST["mbr_pobox"];
    $mbr_city = $_POST["mbr_city"];
    $mbr_state = $_POST["mbr_state"];
    $mbr_zip = $_POST["mbr_zip"];
    $mbr_type = $_POST["mbr_type"];
    $mbr_length = $_POST["mbr_length"];

    //The  mbr_lvl POST value contains the level type and cost separated by a :.  Split the string to get the values
    $a = explode(":", $_POST["mbr_lvl"]);
    $mbr_lvl = $a[0];
    $mbr_lvl_cost = $a[1];
?>