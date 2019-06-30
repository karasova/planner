<div class = "heading"></div>
    <h2>Добавить задачу</h2>
</div>

<div align = center>
<form  method = "POST">
    <table class ="add_event">
        <tr>
            <td>
                Тема:
            </td>
            <td>
                <input type = "text" required  name="theme" value = "<?= isset($_POST['theme']) ? $_POST['theme'] : '' ?>">
            </td>
        </tr>

        <tr>
            <td>
                Тип:
            </td>
            <td>
                <select name="type" >
                    <option value=1>Встреча</option>
                    <option value=2>Звонок</option>
                    <option value=3>Совещание</option>
                    <option value=4>Дело</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>
                Место:
            </td>
            <td>
                 <input type = "text" required  name="place" value = "<?= isset($_POST['place']) ? $_POST['place'] : '' ?>">
            </td>
        </tr>

        <tr>
            <td>
                Дата:
            </td>
            <td>
                <input type = "date" required  name="date" value = "<?= isset($_POST['date']) ? $_POST['date'] : '' ?>">
                <?php echo "\t" . $event->get_error(date) ?>
            </td>
        </tr>
        <tr>
            <td>
                Время:
            </td>
            <td>
                <input type = "time" required  name="time" value = "<?= isset($_POST['time']) ? $_POST['time'] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>
                Длительность:
            </td>
            <td>
                <select name="duration" >
                        <option value="five">5 минут</option>
                        <option value="fifteen">15 минут</option>
                        <option value="half">30 минут</option>
                        <option value="hour">1 час</option>
                        <option value="two">2 часа</option>
                        <option value="three">3 часа</option>
                        <option value="day">Весь день</option>
                </select>
            </td>
        </tr>

        <tr>
                <td>
                    Комментарий:
                </td>
                <td>
                    <textarea rows = "5" name ="comment"> <?= isset($_POST['comment']) ? $_POST['comment'] : '' ?> </textarea>
                </td>
         </tr>
    </table>
    <input type = "submit" value = "Добавить">
    
</form>

<a href ="http://localhost/docs/">Вернуться назад</a>
</div>