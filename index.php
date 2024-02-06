<?php
// Variablen für Verbindungsdetails zur Datenbank
$servername="localhost";
$username="root"; // standard username and password in XAMPP MySql
$password="";
$dbname="todoapp";

// Verbindung zur DB aufbauen 
$connection = new mysqli($servername, $username,$password, $dbname);

// Verbinung überprüfen 
if($connection->connect_error) {
// Wenn Fehler bei Datenbankverbiendung 
die("Connection failed:" . "$connection->connect_error");
}



// Die Daten  vom Browser verarbeiten (aus Form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if( isset ($_POST["add"])) {        // Wurde die Form  mit Name add abgeschickt?
        // Die gesendet Daten in php Variablen speichern 
        $bezeichnung = $_POST ["bezeichnung"];
        $faelligkeit = $_POST ["faelligkeit"];
    


// Todo in der Datenbank speichern 

    // Id generieren 
    $id= rand(); // Zufallszahl
    $id= md5($id); // Daraus String generieren 
    $id=substr($id,0,29); // Gekuerzt auf 30 Zeichen wie DB
$sql= "INSERT INTO Todo (id,bezeichnung,faelligkeit,status) VALUES ('$id', '$bezeichnung', '$faelligkeit', 0)";
$connection->query ($sql);


    }elseif(isset ($_POST ["delete"])) { // Wurde Form mit Name delete abgeschickt?
        $id =$_POST["id"];

        // Todo in DB löschen 
        $sql = "DELETE FROM Todo WHERE id = '$id'";
    $connection->query($sql);

    }elseif(isset($_POST["done"])){    // Wurde Form mit Name done abgeschickt? 
        $id =$_POST["id"];

        // Todo aktualisieren in DB 
        $sql = "UPDATE Todo SET status = 1 WHERE id = '$id'"; 
        $connection->query($sql);
    
    }
}



// Alle Todos aus der Datenbank abfragen
$todos=array ();

//Abfragen an Datenbank vorbereiten 
$sql="SELECT * FROM todo"; 
// Datenbank abfragen und Ergebnins erhalten 
$result=$connection->query($sql);

while($row=$result->fetch_assoc()){   // Ergebnis zeilenweise auslesen 
    $todos[]=$row; //Zeile an Array todos anhängen 
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!--Inhalte aus sytle.css einbinden -->
    <link rel="stylesheet" href="css/style.css">


    <title>Todo App</title>
</head>
<body>

<header class="section">
    <div class="container">
    <h1> Flavi's Todo Liste </h1>
</div>
</header>


 <!--Abschnitt 1: Todo speichern -->
<section class="input-todo">
    <div class="container">
        <h2>
            Neues Todo anlegen
</h2>
 <!--Input zum speichern von Todo auf server -->
 <form class="form" action="" method="post">
 <!--Eine Zeile in Todo Form -->
    <div class="form-row">
    <label  class="form-label"for="bezeichnung">Bezeichnung </label>
    <input type="text" name="bezeichnung"/>
    </div>
 <!--Eine Zeile in Todo Form -->
    <div class="form-row">
    <label  class="form-label"for="faelligkeit">Faelligkeit  </label>
    <input id="faelligkeit" type="date" name="faelligkeit" required/>
    </div>

   <input  class="form-button button" type="submit" value="Todo speichern" name="add"/>
</form>

</div>
</section>

 <!--Abschnitt 2: Todos in Tabelle anzeigen -->
 <section>
    <div class="container">

<!-- Tabelle von Todos -->
<table>
   <!--Tabellenkopf --> 
<thead>
<tr>
    <th>Bezeichnung</th>
    <th>Faelligkeit</th>
    <th>Status</th>
</tr>
</thead>


<!--Tabelleinhalt( Alle Todos) -->
<tbody id="todoList">
    <!--Schleife über alle Todos--> 
<?php foreach ($todos as $todo):?>

<!-- Klasse hinzügefügen um erledigte Todos zu identifizieren -->
    <?php
    if($todo["status"] == 1) {
       echo "<tr class='status_erledigt hidden'>";

    }else {
        echo "<tr>";

    }
    ?>


<td>
    <?php echo $todo["bezeichnung"]  ?>
    </td>
    <td>
    <?php echo $todo["faelligkeit"]   ?>
</td>
<td>


 <!--Status sinnvoll ausdruecken--> 
 <?php 
if ($todo["status"] == 1) {
    echo "erledigt";
} else {
 echo "offen";
 
}

?>
</td>

<td>
  <form action="" method="post" style="display: inline;">
  <input type="hidden" name="id" value="<?php echo $todo["id"]?>"/>
   <!--Button--> 
    <input  class="button" type="submit" name="delete" value="Delete"/>

</form>
</td>

<td>
  <form action="" method="post" style="display: inline;">
  <input type="hidden" name="id" value="<?php echo $todo["id"]?>"/>
   <!--Button--> 
    <input class="button" type="submit" name="done" value="Done"/> 
</form>
</td>
</tr>
    <?php endforeach; ?>
</tbody>
</table>

<!-- Funktion einblenden/ausblenden erledigte Todos -->
<div>
      <label>Erledigte Todos einblenden:</label>
      <input type="checkbox" id="showCompleted"/>
    </div>


</div>
</section>

 <!--Abschnitt: 3 : Todos zählen--> 
<section>
    <div class="container">
    <p>
    Anzahl der Todos (inkl.erledigt): <?php echo count ($todos); ?>
</p>
</div>
</section>

 <!--JavaScript das auf Checkbox reargiert und Klasse hidden bei erledigten Todos hinzufügt und entfernt--> 
 <!--JavaSript wird vom Broweser ausgegührt --> 
 <!--JavaSript Datei einbinden --> 
<script type="text/javascript" src="js/toggleTodos.js"> </script>

<footer>
<h3>&rarr; HFH 2024 &copy by FP😊<h3>
</footer>

</body>
</html>