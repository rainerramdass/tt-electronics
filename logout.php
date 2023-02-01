<?php
    //start session
    session_start();

    //end session
    session_destroy();

    //go back to index page
    header('Location: login.php?logout=true');
    return;

?>