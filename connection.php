<?php

$conn = mysqli_connect("localhost", "root", "", "20bt04004_ashish");

$usertable = "CREATE TABLE IF NOT EXISTS `users` ( `Id` INT NOT NULL AUTO_INCREMENT , `Firstname` VARCHAR(24) NOT NULL , `Lastname` VARCHAR(24) NOT NULL , `Email` VARCHAR(50) NOT NULL , `Address` VARCHAR(240) NOT NULL , `Country` INT NOT NULL , `State` INT NOT NULL , `City` INT NOT NULL , `Gender` VARCHAR(10) NOT NULL , `Password` TEXT NOT NULL , `Profile` VARCHAR(50) NOT NULL , `Timestamp` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`Id`))";

mysqli_query($conn, $usertable);

?>