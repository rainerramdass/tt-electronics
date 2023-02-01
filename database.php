<?php
    //connect to local database tt-electronics
    $db = mysqli_connect('localhost', 'root', '', 'tt_electronics')

    //display connection error
    OR die (mysqli_connect_error());

?>