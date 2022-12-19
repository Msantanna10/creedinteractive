<?php
################### GLOBAL FUNCTIONS
// Check if it's Localhost to run specific functions
function isLocalhost() { 
    return ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') ? true : false; 
    // if(isLocalhost()) { returns true or false }
}
?>