<?php

    class Event {
        private $theme;
        private $type = array(
            1 => 'Встреча', 
            2 => 'Звонок', 
            3 => 'Совещание',
            4 => 'Дело'
        );
        private $t;
        private $place;
        private $date;
        private $time;
        private $duration;
        private $comment;
        private $status;
        private $dateCreate;
        private $dateUpdate;
        private $dateDelete;
        private $id;
        private $errors = array();

        public $table = 'events';
        public $table1 = 'types';
        public $table2 = 'duration';

        public static function get_pdo(){
            $_pdo;
            if (empty($_pdo)) {
                $_pdo = new PDO('mysql:host=localhost; dbname=planner', 'root', ''); 
            }
            return $_pdo;
        }

        public function get_error($key){
            return $this->errors[$key];
        }

        public function check_and_fill(){
            $this->theme = $_POST['theme'];  
            
            $this->t = $_POST['type'];         

            $this->place = $_POST['place'];

            if ($_POST['date'] >= date('Y-m-d'))
                $this->date = $_POST['date'];
            else 
                $this->errors['date'] = 'Дата задачи не может быть позже текущей даты';

            $this->time = $_POST['time'];

            switch ($_POST['duration']) {
                case 'five':
                    $this->duration = 1;
                    break;
                case 'fifteen':
                    $this->duration = 2;
                    break;
                case 'half':
                    $this->duration = 3;
                    break;
                case 'hour':
                    $this->duration = 4;
                    break;
                case 'two':
                    $this->duration = 5;
                    break;
                case 'three':
                    $this->duration = 6;
                    break;
                case 'day':
                    $this->duration = 7;
                    break;
            }

            $this->comment = $_POST['comment'];
            $this->dateCreate = date('Y-m-d-H-i-s');
            $this->dateUpdate = date('Y-m-d-H-i-s');
            $this->status = 'active'; 
            
            //echo $this->theme . " | " .  $this->type . " | " .  $this->place . " | " .  $this->date . " | " .  $this->time . " | " .  $this->duration . " | " .  $this->comment . " | " .  $this->status . " | " .  $this->dateCreate . " | " .  $this->dateUpdate . " | " .  $this->dateDelete;
        }

        public function write_to_db(){
            $sql = static::get_pdo()->prepare('INSERT INTO `' . $this->table . '` (`theme`, `type_id`, `place`, `date`, `time`, `duration_id`, `comment`, `status`, `created_at`, 
            `updated_at`, `deleted_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?);');
            $sql->execute(array($this->theme, $this->t, $this->place, $this->date, $this->time, $this->duration, $this->comment, $this->status, $this->dateCreate, $this->dateUpdate, $this->dateDelete));
            
            return $sql->rowCount() === 1;
        }

        public function add_event(){
            $this->check_and_fill();

            if(empty($this->errors)){
                if ($this->write_to_db())
                    header('location: index.php');
                exit;
            }
        }

        public function read_from_db(){
            if (!isset($_POST['plantype'])){
                $sort_type = 1;
            }
            else{
                $sort_type = $_POST['plantype'];
            }
            

            if ($sort_type == 1){            
                $sql = static::get_pdo()->prepare('SELECT t1.id,type_id, theme, place, date, time, status FROM `'. $this->table . '` t1,`' . $this->table1 . 
                '` t2 WHERE t1.type_id = t2.id AND `deleted_at` is NULL order by date;'); 
            }

            if ($sort_type == 2 ){
                $sql = static::get_pdo()->prepare('SELECT t1.id, type_id, theme, place, date, time, status FROM `'. $this->table . '` t1,`' . $this->table1 . 
                '` t2 WHERE t1.type_id = t2.id AND `deleted_at` is NULL AND `status` = "active" order by date;');
            }

            if ($sort_type == 3 ){
                $sql = static::get_pdo()->prepare('SELECT t1.id, type_id, theme, place, date, time, status FROM `'. $this->table . '` t1,`' . $this->table1 . 
                '` t2 WHERE t1.type_id = t2.id AND `deleted_at` is NULL AND `status` = "active" AND `date` < "'.date('Y-m-d'). '"');
            }

            if ($sort_type == 4 ){
                $sql = static::get_pdo()->prepare('SELECT t1.id, type_id, theme, place, date, time, status FROM `'. $this->table . '` t1,`' . $this->table1 . 
                '` t2 WHERE t1.type_id = t2.id AND `deleted_at` is NULL AND `status` = "done" order by date;');                
            }

            if (!empty($_POST['plan_date']))
            {
                $date_sort = $_POST['plan_date'];

                $sql = static::get_pdo()->prepare('SELECT t1.id, type_id, theme, place, date, time, status FROM `'. $this->table . '` t1,`' . $this->table1 . 
                '` t2 WHERE t1.type_id = t2.id AND `deleted_at` is NULL AND `date` = "'.$date_sort. '"');
            }

            $sql->execute(); 

            $str = "";

                while ($object = $sql->fetchObject(static::class)){
                    $id = $object->id;
                    $str .= "<tr><td>" . $this->type[$object->type_id] . "</td><td><a href= 'planner/task.php?id=$object->id'>" . $object->theme . "</a></td><td>" . $object->place . "</td><td>" . $object->date . "</td><td>" . 
                    $object->time . "</td><td>" . $object->status . "</td><td><input type='checkbox' name='dones[]' value = ". $id . "></td></tr>" ;
                }

            return $str;
        }

        public function put_done(){
            if (!empty($_POST['dones'])){
                $dones = $_POST['dones'];                
                
                foreach ($dones as $key){
                    $sql = $this->get_pdo()->prepare('UPDATE `'.$this->table.'` SET `status` = "done" WHERE `id` = ?;');
                    $sql->execute(array($key));
                }
            }
        }

        public function read_by_id($id){
            $sql = static::get_pdo()->prepare('SELECT * FROM `' . $this->table . '` WHERE `id` =' . $id . ';');
            $sql->execute();

            $object = $sql->fetchObject(static::class);
            $this->id = $id;
            $this->theme = $object->theme;
            $this->type = $object->type;
            $this->place = $object->place;
            $this->date = $object->date;
            $this->time = $object->time;
            $this->duration = $object->duration;
            $this->comment = $object->comment;
            $_POST['theme'] = $object->theme;
            $_POST['type'] = $object->type;
            $_POST['place'] = $object->place;
            $_POST['date'] = $object->date;
            $_POST['time'] = $object->time;
            $_POST['duration'] = $object->duration;
            $_POST['comment'] = $object->comment;
        }

        public function update_db(){
            $this->theme = isset($_POST['theme']) ? trim($_POST['theme']) : null;
		    $this->type = isset($_POST['type']) ? $_POST['type'] : null;
            $this->place = isset($_POST['place']) ? trim($_POST['place']) : null;
            $this->date = isset($_POST['date']) ? trim($_POST['date']) : null;
            $this->time = isset($_POST['time']) ? trim($_POST['time']) : null;
            $this->duration = isset($_POST['duration']) ? trim($_POST['duration']) : null;
            $this->comment = isset($_POST['comment']) ? trim($_POST['comment']) : null;

            $this->dateUpdate = date('Y-m-d-H-i-s');

            if(empty($this->errors)){
                $sql = static::get_pdo()->prepare('UPDATE `'.$this->table.'` SET `theme`= ?, `type`= ?, `place`= ?, `date`= ?, `time`= ?, `duration`= ?, `comment`= ?, `dateUpdate` = ? where `id`= ? limit 1;');
                $sql->execute(array($this->theme, $this->type, $this->place, $this->date, $this->time, $this->duration, $this->comment, $this->dateUpdate, $_GET['id']));
                //header('location: index.php');
            }
        }
    }
?>

