<?php
function genre($db, $genre)
{
    $statement = $db->prepare("SELECT name, `date`, country, quality, carrier 
    FROM film INNER JOIN film_genre ON ID_Film = FID_Film 
    INNER JOIN genre ON FID_Genre = ID_Genre
    WHERE `title` = ?");
    $statement->execute([$genre]);
    echo "<table>";
    echo " <tr>
     <th> Название  </th>
     <th> Дата </th>
     <th> Страна </th>
     <th> Оценка </th>
     <th> Носитель </th>
    </tr> ";
    while ($data = $statement->fetch()) {
        echo " <tr>
         <td> {$data['name']}  </td>
         <td> {$data['date']} </td>
         <td> {$data['country']} </td>
         <td> {$data['quality']} </td>
         <td> {$data['carrier']} </td>
        </tr> ";
    }
    echo "</table>";
}

function actor($db, $actor)
{
    $statement = $db->prepare("SELECT film.name as 'name', `date`, country, quality, carrier 
    FROM film INNER JOIN film_actor ON ID_Film = FID_Film 
    INNER JOIN actor ON FID_Actor = ID_Actor
    WHERE actor.name = ?");
    $statement->execute([$actor]);
    $return = "<table>";
    $return .= " <tr>
     <th> Название  </th>
     <th> Дата </th>
     <th> Страна </th>
     <th> Оценка </th>
     <th> Носитель </th>
    </tr> ";
    while ($data = $statement->fetch()) {
        $return .= " <tr>
         <td> {$data['name']}  </td>
         <td> {$data['date']} </td>
         <td> {$data['country']} </td>
         <td> {$data['quality']} </td>
         <td> {$data['carrier']} </td>
        </tr> ";
    }
    $return .= "</table>";
    echo json_encode($return);
}

function datePeriod($db, $start, $end)
{
    $statement = $db->prepare("SELECT name, `date`, country, quality, carrier FROM film WHERE `date` BETWEEN ? AND ?");
    $statement->execute([$start, $end]);
    echo "<table>";
    echo " <tr>
     <th> Название  </th>
     <th> Дата </th>
     <th> Страна </th>
     <th> Оценка </th>
     <th> Носитель </th>
    </tr> ";
    while ($data = $statement->fetch()) {
        echo " <tr>
         <td> {$data['name']}  </td>
         <td> {$data['date']} </td>
         <td> {$data['country']} </td>
         <td> {$data['quality']} </td>
         <td> {$data['carrier']} </td>
        </tr> ";
    }
    echo "</table>";
}

$db = new PDO("mysql:host=127.0.0.1;dbname=films", "root", "");

if(isset($_POST["genre"])) {
    genre($db, $_POST["genre"]);
} elseif(isset($_POST["actor"])) {
    actor($db, $_POST["actor"]);
} elseif (isset($_POST["start"])) {
    datePeriod($db, $_POST["start"], $_POST["end"]);
}