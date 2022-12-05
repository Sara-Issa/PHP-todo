<?php 

// mysql connection
$conn = mysqli_connect('localhost', 'sara', 'test1234', 'todo');

// check connection
if (!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

?>