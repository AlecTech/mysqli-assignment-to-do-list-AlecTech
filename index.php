<?php
require 'constants.php';

if ( $_POST)
{
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
        
        if( $connection->connect_errno ) 
        {
            die('Connection failed:' . $connection->connect_error);
        }

        //    PREPARED STATEMENT
        if( $statement = $connection->prepare("INSERT INTO todos (todoTitle, duedate, catID) VALUES(?,?,?)"))
        {
            if($statement->bind_param("ssd", $_POST['title'], $_POST['due_date'], $_POST['category']))
            {
                if( $statement->execute() ) 
                {
                    echo  "Yay! We've added" . $_POST['title'] ." to the database";
                } 
                else
                {
                    echo "There was a problem with the execute";
                }
            }
            else
            {
                echo "There was a problem with the bind_param";
            }
        }
        else 
        {
            echo "There was a problem adding a task member to the database";
        }
        $statement->close();
        $connection->close();


}


// $id = null;
$tasks = null;
$cats = null;
$donetasks = null;
$overdues = null;

// if( !isset( $_GET['id'] ) || $_GET['id'] === "" ) {
//     echo "You have reached this page by mistake.";
//     exit();
// }

// if( filter_var($_GET['id'], FILTER_VALIDATE_INT) ) {
//     $id = $_GET['id'];
// } else {
//     die("An incorrect value for ID was passed");
// }

// Create connection
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Did we have errors connecting?
if ($connection->connect_error) {
die('Connection failed: ' . $connection->connect_error);
}
// SET UP YOUR SELECT SQL STATEMENT
$sql = 'SELECT todos.id, todos.todoTitle, todos.date, categories.name , todos.checked, todos.duedate FROM todos INNER JOIN categories ON todos.catID = categories.catID ORDER BY todos.id DESC';

$category_id = 'SELECT categories.catID, categories.name FROM categories';

$completed = 'SELECT todos.id, todos.todoTitle, todos.date, todos.catID, todos.checked, todos.duedate FROM todos WHERE todos.checked = 1';

$overduetasks = 'SELECT todos.id, todos.todoTitle, todos.date, categories.name , todos.checked, todos.duedate FROM todos INNER JOIN categories ON todos.catID = categories.catID WHERE todos.duedate < NOW()';

if( !$result = $connection->query($sql) ) 
{
    echo "Something went wrong with the sql query";
    exit();
}

// QUERY USING YOUR SQL STATEMENT
$result = $connection->query($sql);

$result_category = $connection->query($category_id);

$result_completed = $connection->query($completed);

$result_overdue = $connection->query($overduetasks);
// start a bunch of if and while loop statments to output data
// this 1st if while statment is for categories to show inside select option (dropdown menu)
if($result_category->num_rows > 0) 
{
    while ($row_cat = $result_category->fetch_assoc()) 
    {
        // echo '<pre>';
        // print_r($row_cat);
        // echo '</pre>';

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
// 2nd if while for the completed section
if($result_completed->num_rows > 0)
{
    while ($row_completed = $result_completed->fetch_assoc())
    {
        // echo '<pre>';
        // print_r($row_completed);
        // echo '</pre>';

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
                    <div> <input type="button" value="edit" onclick="window.location.href=`edit.php?id=%d`" > <span> &emsp; </span> 
                    <input type="button" value="delete" onclick="window.location.href=`delete.php?id=%d`"> </div>
                </div>
            </div
            
        ',
            $row_completed['id'],
            $row_completed['todoTitle'],
            $row_completed['date'],
            $row_completed['catID'],
            $row_completed['duedate'],
            $row_completed['id'],
            $row_completed['id'],
        );

    }
}
// 3rd if while for the overdue section
if (0 === $result_overdue->num_rows ) 
{
    $overdues = "There are no over due tasks";
}
else
{
    while( $row_overdue = $result_overdue->fetch_assoc() )
    {
        // echo '<pre>';
        // print_r($row_overdue);
        // echo '</pre>';
     
        $overdues .= sprintf
        ('
            <div class="show-todo-list">
                <div class="todo-item">
                    
                    <h3>%d</h3>
                    <div>
                    <h3 id="overdue">%s</h3>

        ',
                $row_overdue['id'],
                $row_overdue['todoTitle'],
            
         );

         if ($row_overdue['checked'] == 1)
         {
             $overdues .= '<input value="'.$row_overdue['checked'].'" type="checkbox" checked>';
         }
         else
         {
            $overdues .= '<input value="'.$row_overdue['checked'].'" type="checkbox">';
         }
         $overdues .= sprintf
         ('
                    </div>
                    <small>%s</small>
                    <h3>%s</h3>
                    <small>%s</small>
                    
                    <div> <input type="button" value="edit" onclick="window.location.href=`edit.php?id=%d`"> <span> &emsp; </span> 
                    <input type="button" value="delete" onclick="window.location.href=`delete.php?id=%d`"> </div>
                </div>
            </div>

        ',
                $row_overdue['date'],
                $row_overdue['name'],
                $row_overdue['duedate'],
                $row_overdue['id'],
                $row_overdue['id'],

        );
    }
}


// TEST TO SEE IF YOUR QUERY RETURNED ANY RESULTS
// 4th if while for the all results from the sql db
if (0 === $result->num_rows ) 
{
    $tasks = "There are no tasks";
}
else
{
    while( $row = $result->fetch_assoc() )
    {
        // echo '<pre>';
        // print_r($row);
        // echo '</pre>';
     
        $tasks .= sprintf
        ('
            <div class="show-todo-list">
                <div class="todo-item">

                    <form action="status.php" method="POST">
                    <h3>%d</h3>
                   
                    <h3>%s</h3>

        ',
                $row['id'],
                $row['todoTitle'],
            
         );

         if ($row['checked'] == 1)
         {
             $tasks .= '
             <input value="'.$row['checked'].'" name="'.$row['id'].'" type="hidden">
             <input value="'.$row['checked'].'" type="checkbox" checked>';
         }
         else
         {
            $tasks .= '
            <input value="'.$row['checked'].'" name="'.$row['id'].'" type="hidden">
            <input value="'.$row['checked'].'" type="checkbox">';
         }

         $tasks .= sprintf
         ('
                    </form>
                    <small>%s</small>
                    <h3>%s</h3>
                    <small>%s</small>
                    <div> <input type="button" value="edit" onclick="window.location.href=`edit.php?id=%d`">  <span> &emsp; </span> 
                    <input type="button" value="delete" onclick="window.location.href=`delete.php?id=%d`"> </div>
                </div>
            </div>

        ',
                $row['date'],
                $row['name'],
                $row['duedate'],
                $row['id'],
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
    <script>
        if ( window.history.replaceState ) 
        {window.history.replaceState( null, null, window.location.href );}
    </script>
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
                    <?php echo $overdues; ?>
                </div>
            </div>
        </form>

        <?php echo $tasks;  ?>

    </div>
   
</div>

<script>
    const checkboxes = document.querySelectorAll('input[type=checkbox]');
    checkboxes.forEach(ch => {
        ch.onclick = function (){
            this.parentNode.submit();
        };
    })

</script>
    
    
</body>
</html>