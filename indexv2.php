</html>

<!DOCTYPE HTML>
<html>
    <title>dbiketracker</title>
    <head>
        <?php
        //connect to ClearDB
        //cleardb url mysql://b4c04b4b0847ac:bdfbd3f7@us-cdbr-iron-east-04.cleardb.net/heroku_1aebd2cf6f33fe1?reconnect=true
        //gets the variables from the url and parses them to the variables
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);
        //create the conneciton
//        $conn = new mysqli($server, $username, $password, $db);
        $conn = mysqli_connect($server, $username, $password, $db) or die('Error in Connecting: ' . mysqli_error($conn));

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";

        //information for the bikes api
        $api_key = "ec447add626cfb0869dd4747a7e50e21d39d1850";
        $contract_name = "Dublin";
        //phpinfo();
        $api_url = "https://api.jcdecaux.com/vls/v1/stations?contract=Dublin&apiKey=ec447add626cfb0869dd4747a7e50e21d39d1850";
        $contents = file_get_contents($api_url);
        //convert the json to a php assoc array for query
        $dbikeinfo = json_decode($contents, true);

//        //insert into availability table
//        $st = mysqli_prepare($conn, 'INSERT INTO availability(number, timeslot, avail_bikes, avail_slots, status) VALUES (?, ?, ?, ?, ?)');
//        //bind the varibales
//        mysqli_stmt_bind_param($st, 'isiis', $number, $timeslot, $avail_bikes, $avail_slot, $status);
//
//        // loop through the array
//        foreach ($dbikeinfo as $row) {
//            // get the locations details
//            $number = $row['number'];
//            $timeslot = strftime("%Y-%m-%d, %H:%M:%S", time());
//            $avail_bikes = $row['available_bikes'];
//            $avail_slot = $row['available_bike_stands'];
//            $status = $row['status'];
//            $timestamp = $row['last_update'];
//
////            echo '<pre>';
////            print_r($number);
////            print_r($timeslot);
////            print_r($avail_bikes);
////            print_r($avail_slot);
////            print_r($status);
////            echo '</pre>';
//            // execute insert query
//            mysqli_stmt_execute($st);
//        }
        //close connection
//        mysqli_close($conn);


        //insert new time stamp every 10 minutes
        $st = mysqli_prepare($conn, 'INSERT INTO times(time, dayofwk) VALUES ($time, $dayofwk)');
//        //bind the varibales
        mysqli_stmt_bind_param($st, 'ss', $time, $dayofwk);
        $time = date('H:i', strtotime());
        $dayofwk = date();
        
        
        // execute insert query
        mysqli_stmt_execute($st);
        ?>
    </head>
</html>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  //connect to ClearDB
        //cleardb url mysql://b4c04b4b0847ac:bdfbd3f7@us-cdbr-iron-east-04.cleardb.net/heroku_1aebd2cf6f33fe1?reconnect=true
        //gets the variables from the url and parses them to the variables
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);
        //create the conneciton
//        $conn = new mysqli($server, $username, $password, $db);
        $conn = mysqli_connect($server, $username, $password, $db) or die('Error in Connecting: ' . mysqli_error($conn));

        //insert new time stamp every 10 minutes
        $st = mysqli_prepare($conn, 'INSERT INTO times(time, dayofwk) VALUES ($time, $dayofwk)');
//        //bind the varibales
        mysqli_stmt_bind_param($st, 'ss', $time, $dayofwk);
        $time = date('H:i', strtotime());
        $dayofwk = date();
        
        
        // execute insert query
        mysqli_stmt_execute($st);
        



        //close connection
        mysqli_close($conn);

        // loop through the array
        // foreach ($dbikeinfo as $row) {
            // get the locations details
             // $row['number'] = $number;
             // $row['name'] = $name;
             // $row['position']['lat'] = $lat;
             // $row['position']['lng'] $lng = ;
//            
//             echo '<pre>';
//             print_r($number);
//             print_r($name);
//             print_r($lat);
//             print_r($lng);
//             echo '</pre>';
//            
            //execute insert query
            // mysqli_stmt_execute($st);
        // }
