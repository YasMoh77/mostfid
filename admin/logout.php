<?php

session_start( );
unset($_SESSION['nameMos']);//just empty the session
unset($_SESSION['idMos']);//just empty the session

//session_unset( );
//session_destroy( );

//after logging out, go to index.php
header('location:index.php');
exit();

