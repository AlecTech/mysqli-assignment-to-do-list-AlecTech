<?php

require 'constants.php';
$id = null;
//var values would be coming from sql db
$show_edit_id = null;
$edit_todoTitle = null;
$edit_checked = null;
$show_edit_date = null;
$edit_duedate = null;
$edit_catID = null;

// make a connection and test if failed
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
if( $connection->connect_errno ) 
{
    die('Connection failed:' . $connection->connect_error);
}

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';

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
    
    // prepare template query which will pull data out of db in the next step
    $sql = "SELECT * FROM todos WHERE todos.id = $id";
    // assign the data from sql to the $result (inside is just an object with our query do var dump to understand)
    $result = $connection->query($sql);
    echo '<pre>';
    var_dump($result);
    echo '</pre>';
    if( !$result ) 
    {
        exit('There was a problem fetching results');
    }
    if( 0 === $result->num_rows ) 
    {
       
        exit("There was no task with that ID");
    }
    // pre-populate the selected task that we want to update/edit
    // only now inside $row you will see our todos data like we used to see it in the table
    while( $row = $result->fetch_assoc() ) 
    {
         echo '<pre>';
        var_dump($row);
        echo '</pre>';

        $show_edit_id = $row['id'];
        $edit_todoTitle = $row['todoTitle'];
        $edit_checked = $row['checked'];
        $show_edit_date = $row['date'];
        $edit_duedate = $row['duedate'];
        $edit_catID = $row['catID'];

    }
    $connection->close();

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

    <form action="#" method="POST" enctype="multipart/form-data">

    <?php echo $show_edit_id; ?>

    <p>
        <label for="todoTitle">Todo Task</label>
        <input type="text" name="todoTitle" id="todoTitle" value="<?php echo $edit_todoTitle; ?>">
    </p>

    <p>
        <h3>Status Checked</h3>
        <input type="hidden" name="<?php echo $show_edit_id; ?>" id="check-status" value="<?php echo $edit_checked; ?>">
        <input value="<?php echo $edit_checked; ?>" type="checkbox" >
    </p>

    <p>
        <h3>Date</h3>
     <?php echo $show_edit_date; ?>
  
    </p>

    <p>
        <label for="duedate">Edit Due Date</label>
        <input type="date" name="duedate" id="duedate" value="<?php echo $edit_duedate; ?>" min="2020-09-01" max="2021-09-01">
        
    </p>

    <p>
        
        <label for="catID">Edit Category</label>
        <input type="number" name="catID" id="catID" value="<?php echo $edit_catID; ?>" min="1" max="2">
        <small>Note: to edit category type 1 for Chores or 2 for Homework</small>
<!-- 
        <lable for="category"> Task Category</lable>
            <select name="category" id="category">
                <option value="">select category</option>

                
            </select> -->
    </p>

    <p>
        <input type="submit" value="Submit edits">
    </p>
    </form>
   

</body>
</html>