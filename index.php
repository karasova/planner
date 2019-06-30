<!DOCTYPE html>
<html>
<head>
    <title> Регистрация </title>
    <link rel = "stylesheet" type ="text/css" href = "planner/css/style.css">
</head>
<body>
    <?php
        //error_reporting(0);
        include "planner/model/event_class.php";

        $events = new Event;
        if (!empty($_POST))
            $events->add_event();
            
        include "views/calendar.php";
        include "views/plans.php";
    ?>
</body>
</html>

