<?php
require 'constants.php';
echo '<pre>';
var_dump($_POST);
echo '</pre>';

$id = null;
$delete_todoTitle = null;

$show_form = true;
$message = null;

$connection = new MySQLi(HOST, USER, PASSWORD, DATABASE);
if( $connection->connect_errno ) {
    die("Connection failed:" . $connection->connect_error);
}

// (!$_POST) this POST used to display Task for Deletion
if( !$_POST ) {
    if( !isset($_GET['id']) || $_GET['id'] === "" ) {
        exit("You have reached this page by mistake");
    }
    if( filter_var($_GET['id'], FILTER_VALIDATE_INT) ) {
        $id = $_GET['id'];
    } else {
        exit("An incorrect value for task ID was used");
    }
    $sql = "SELECT * FROM todos WHERE todos.id = $id";
    $result = $connection->query($sql);
    if( !$result ) {
        exit("There was a problem fetching results");
    }
    if( 0 === $result->num_rows ) {
        exit("The task id provided did not match anyone in the database");
    }

    while( $row = $result->fetch_assoc() ) {
        $delete_todoTitle = $row['todoTitle'];
    }
}

// this POST used to DELETE actual task
if( $_POST ) {
    $show_form = false;
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    if( filter_var($_POST['id'], FILTER_VALIDATE_INT) ) {
        $id = $_POST['id'];
    } else {
        exit("An incorrect value for task ID was used");
    }

    $task_sql = "SELECT * FROM todos WHERE todos.id = $id";
    $result = $connection->query($task_sql);
    if( !$result ) {
        exit("There was a problem fetching results");
    }
    if( 0 !== $result->num_rows ) {
        $delete_sql = "DELETE FROM todos WHERE todos.id = $id";
        if( $connection->query($delete_sql) ) {
            $message = "Task DELETED successfully";
        } else {
            exit("There was a problem deleting this task");
        }
    } 
    header( "refresh:4;url=index.php" );
    echo ' Wait 4 secs to be redirected.';
}
$connection->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Task</title>
</head>
<body>
    <h1> Delete Todo Task</h1>

   <h1>Remove Task</h1>
    <?php if( $show_form ): ?>
        <form action="#" method="POST" enctype="multipart/form-data">
            <h2>Are you certain you want to DELETE " <?php echo $delete_todoTitle; ?> " TASK</h2>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Yes, delete this task">
        </form>
    <?php else: ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>


</body>
</html>