<?php

require 'constants.php';
$id = null;

echo '<pre>';
var_dump($_POST);
echo '</pre>';

  // If we don't have a staff id, do not continue
  if( !isset($_GET['id']) || $_GET['id'] === "" ) 
  {
    exit("You have reached this page by mistake");
  }

    // If the staff id is not an INT, do not continue
    if( filter_var($_GET['id'], FILTER_VALIDATE_INT ) ) 
    {
        $id = $_GET['id'];
    } 
    else 
    {
        exit("An incorrect value was passed");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>
    <h1> Edit Todo Task</h1>
   

</body>
</html>