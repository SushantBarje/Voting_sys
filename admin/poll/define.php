<?php
    DEFINE('DB_USER','root');
    DEFINE('DB_PASS','');
    DEFINE('DB_HOST','localhost');
    DEFINE('DB_DB','voting');

    function connect() {
        $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_DB);
        return $con;   
    }


?>