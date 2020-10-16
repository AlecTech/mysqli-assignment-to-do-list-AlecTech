<?php
require 'constants.php';
// Create connection
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Did we have errors connecting?
if ($connection->connect_error) {
die('Connection failed: ' . $connection->connect_error);
}

// SET UP YOUR SELECT SQL STATEMENT
$sql = 'SELECT * FROM todos';
// QUERY USING YOUR SQL STATEMENT
$result = $connection->query($sql);
// TEST TO SEE IF YOUR QUERY RETURNED ANY RESULTS
if( $result->num_rows > 0) 
    { //we have results!
        echo "we have data";
    }
    else
    {
        echo "we missing data";
    // while($row = $result->fetch_assoc()) {
    // DO SOMETHING WITH THE ROW’S DATA
    }
    // }



$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO-DO APP</title>
    <link rel="stylesheet" href="css/style.css" >
</head>
<body>
<div class="main-section">
    <div class="add-section">
        <form action="#">
            <input type="text"
                    name="title"
                    placeholder="Enter your task here..."/>
            <button type="submit"> Add &nbsp; <span>&#43;</span></button>
        </form>
    </div>
    <div class="show-todo-list">
        <div class="todo-item">
            <br>
            <input type="checkbox">
            <h2>This is new task</h2>
            <small>date created 1/1/2020</small>
        </div>
    </div>
</div>
    
    
</body>
</html>