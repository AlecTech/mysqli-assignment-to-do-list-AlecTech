<?php
require 'constants.php';

$tasks = null;
$cats = null;

// Create connection
$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Did we have errors connecting?
if ($connection->connect_error) {
die('Connection failed: ' . $connection->connect_error);
}
// SET UP YOUR SELECT SQL STATEMENT
$sql = 'SELECT todos.id, todos.todoTitle, todos.date, todos.catID, todos.checked, todos.duedate FROM todos';

$category_id = 'SELECT categories.catID, categories.name FROM categories';
// QUERY USING YOUR SQL STATEMENT
$result = $connection->query($sql);

$result_category = $connection->query($category_id);

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
// TEST TO SEE IF YOUR QUERY RETURNED ANY RESULTS

// if( $result->num_rows > 0) 
//     { //we have results!
//          // DO SOMETHING WITH THE ROW’S DATA
//         while( $row = $result->fetch_assoc() )
//         {
//             echo '<pre>';
//             print_r($row);
//             echo '</pre>';
//         }
//     }
//     else
//     {
//         echo "we missing data";   
//     }

    // same test
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
                    <br>
                    <h3>%d</h3>
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

                    <small>%s</small>
                    <h3>%d</h3>
                    <small>%s</small>
                </div>
            </div>

        ',
                $row['date'],
                $row['catID'],
                $row['duedate'],

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
        <form action="#" method="GET" enctype="multipart/form-data">
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

        </form>
    </div>
    <div class="show-todo-list">
        <div class="todo-item">
            <br>
            <h2>Completed ToDo list:</h2>
            <input type="checkbox">
            <h2></h2>
            <small>date created 1/1/2020</small>
        </div>
    </div>
    <div class="show-todo-list">
        <div class="todo-item">
            <br>
            <h2>Overdue list:</h2>
            <input type="checkbox">
            <h2></h2>
            <small>date created 1/1/2020</small>
        </div>
    </div>
    <?php echo $tasks;  ?>
</div>
    
    
</body>
</html>