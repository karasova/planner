<link rel = "stylesheet" type ="text/css" href = "planner/css/style.css">

<?php
        //error_reporting(0);
        include "App/event_class.php";

        $event = new Event;

        if (!empty($_GET) and empty($_POST)){
            $event->read_by_id($_GET['id']);
        }

        if (!empty($_GET) and !empty($_POST)) {
            $event->update_db();
        }

        include "views/task_info.php";
?>