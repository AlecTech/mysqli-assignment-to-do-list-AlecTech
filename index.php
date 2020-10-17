<?php
require 'constants.php';

$tasks = null;
$cats = null;
$donetasks = null;

// Create connection
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Did we have errors connecting?
if ($connection->connect_error) {
die('Connection failed: ' . $connection->connect_error);
}
// SET UP YOUR SELECT SQL STATEMENT
$sql = 'SELECT todos.id, todos.todoTitle, todos.date, categories.name , todos.checked, todos.duedate FROM todos INNER JOIN categories ON todos.catID = categories.catID';

$category_id = 'SELECT categories.catID, categories.name FROM categories';

$completed = 'SELECT todos.id, todos.todoTitle, todos.date, todos.catID, todos.checked, todos.duedate FROM todos WHERE todos.checked = 1';


// QUERY USING YOUR SQL STATEMENT
$result = $connection->query($sql);

$result_category = $connection->query($category_id);

$result_completed = $connection->query($completed);
// start a bunch of if and while loop statments to output data
if($result_category->num_rows > 0) 
{
    while ($row_cat = $result_category->fetch_assoc()) 
    {
        echo '<pre>';
        print_r($row_cat);
        echo '</pre>';

        $cats .= sprintf
        ('
            <option value="%s">
            %s</option>

        ',
            $row_cat['catID'],
            $row_cat['name']
         );
    }
}

if($result_completed->num_rows > 0)
{
    while ($row_completed = $result_completed->fetch_assoc())
    {
        echo '<pre>';
        print_r($row_completed);
        echo '</pre>';

        $donetasks .= sprintf
        ('
            
            <div class="show-todo-list">
                <div class="todo-item">
                    
                    <h3>%d</h3>
                    <div>
                        <h3>%s</h3>
                        <input value="checked" type="checkbox" checked>
                    </div>
                    <small>%s</small>
                    <h3>%d</h3>
                    <small>%s</small>
                    <div> <input type="button" value="edit" onclick="window.location.href=`edit.php?id=%d`" > <span> &emsp; </span> <input type="button" value="delete"> </div>
                </div>
            </div
            
        ',
            $row_completed['id'],
            $row_completed['todoTitle'],
            $row_completed['date'],
            $row_completed['catID'],
            $row_completed['duedate'],
            $row_completed['id'],
        );

    }
}
// TEST TO SEE IF YOUR QUERY RETURNED ANY RESULTS

if (0 === $result->num_rows ) 
{
    $tasks = "There are no tasks";
}
else
{
    while( $row = $result->fetch_assoc() )
    {
        echo '<pre>';
        print_r($row);
        echo '</pre>';
     
        $tasks .= sprintf
        ('
            <div class="show-todo-list">
                <div class="todo-item">
                    
                    <h3>%d</h3>
                    <div>
                    <h3>%s</h3>

        ',
                $row['id'],
                $row['todoTitle'],
            
         );

         if ($row['checked'] == 1)
         {
             $tasks .= '<input value="'.$row['checked'].'" type="checkbox" checked>';
         }
         else
         {
            $tasks .= '<input value="'.$row['checked'].'" type="checkbox">';
         }

         $tasks .= sprintf
         ('
                    </div>
                    <small>%s</small>
                    <h3>%s</h3>
                    <small>%s</small>
                    
                    <div> <input type="button" value="edit" onclick="window.location.href=`edit.php?id=%d`" > <span> &emsp; </span> <input type="button" value="delete"> </div>
                </div>
            </div>

        ',
                $row['date'],
                $row['name'],
                $row['duedate'],
                $row['id'],

        );
    }
}


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
        <form action="#" method="POST" enctype="multipart/form-data">
            <input type="text"
                    name="title"
                    placeholder="Enter your task here..."/>
            <lable for="due_date">Due Date</lable>
            <input type="date" name="due_date" min="2020-09-01" max="2021-09-01">
            <lable for="category"> Task Category</lable>
            <select name="category" id="category">
                <option value="">select category</option>
                <?php echo $cats; ?>
            </select>
            <button type="submit"> Add &nbsp; <span>&#43;</span></button>

            <div class="show-todo-list">
                <div class="todo-item">
                    <h2>Completed ToDo list:</h2>
                    <?php echo $donetasks;?>
                </div>
            </div>
            <div class="show-todo-list">
                <div class="todo-item">
                    <h2>Overdue list:</h2>
                    
                </div>
            </div>
        </form>

        <?php echo $tasks;  ?>

    </div>
   
</div>
    
    
</body>
</html>