# Name of DB file

# Trello Link

https://trello.com/b/93WzXLsd/alec-to-do-app-php-sql-full-stack

# ERD Diagram

# SQL file

# Citation summary

# CSS borrowed from

https://github.com/codingWithElias/php-to-do-list/blob/master/css/style.css

# if statment to check if checkbox is 1 or 0
       if ($row['checked'] == 1)
         {
             $tasks .= '<input value="'.$row['checked'].'" type="checkbox" checked>';
         }
         else
         {
            $tasks .= '<input value="'.$row['checked'].'" type="checkbox">';
         }

<!-- instead of having this inside the sprintf 
//   `<input value="%d" type="checkbox">
                // $row['checked'],    `          -->