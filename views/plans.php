<div class = "heading">
<h2>Мой календарь</h2>
</div>
<div align = center>
<form method = "POST">
    <p><select name="plantype" >
        <option value=1>Все задачи</option>
        <option value=2>Текущие задачи</option>
        <option value=3>Просроченные задачи</option>
        <option value=4>Выполненные задачи</option>
    </select> 
    <input type = "date" name="plan_date" value = "<?= isset($_POST['con_date']) ? $_POST['con_date'] : '' ?>">
    <input type = "submit" value = "Показать">
    </p>
</form>

<form method = "POST">
    <table class="event_table">
        <thead>
            <tr>
                <th>Тип</th>
                <th>Задача</th>
                <th>Место</th>
                <th>Дата</th>
                <th>Время</th>
                <th>Состояние</th>
                <th>Выполнение</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $events->put_done();
                echo $events->read_from_db();
            ?>
        </tbody>
    </table>
    <input type = "submit" value = "Применить">
</form>
</div>