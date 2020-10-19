<?php
    
    require 'constants.php';

    $id = null;
    //var values would be coming from sql db
    $show_edit_id = null;
    $status_checked = null;
 
    $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if( $connection->connect_errno ) 
    {
        die('Connection failed:' . $connection->connect_error);
    }

    if($_POST)
    {
        $my_post = $_POST;
        // just get the first key = id
        $id = array_key_first($my_post);
        // just get the value without specifing key( since there is only one entry this method works)
        $status_checked = current( $my_post);
        // invert value of status
        if($status_checked == 0)
        {
            $status_checked ++;
        }
        else
        {
            $status_checked --;
        }
        // echo '<pre>';
        // print_r($status_checked);
        // echo '</pre>';

        // UPDATE SQL database with inverted values
        if ($statement = $connection->prepare("UPDATE todos SET todos.checked=? WHERE todos.id=?") )
        {
            if( $statement->bind_param("dd", $status_checked, $id) ) 
            {
                if( $statement->execute() ) 
                {
                $message = "You have updated successfully";
                } 
                else 
                {
                    exit("There was a problem with the execute");
                }
            }
            else 
            {
            exit("There was a problem with the bind_param");
            }
        } 
            else 
            {
                exit("There was a problem with the prepare statement");
            }
            $statement->close();

            // header( "refresh:4;url=index.php" );
            // echo ' Status CHANGED Wait 4 secs to be redirected.';
            header ('Location: index.php');
    }
  ?>      