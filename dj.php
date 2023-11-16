<?php
 # ******************************************
 # - dj.php
 # 
 # - DJ Interface
 # - Displays the queues
 #
 # *****************************************/

include("secrets.php");
include("library.php");
include("dropdown.styles.css");

echo "<head>
        <title>Lux Karaoke</title>
        <link rel=\"stylesheet\" href=\"dropdown.styles.css\">
      </head>";
echo "<body>";
echo "<h1>♕ The Lux Karaoke Bar ♕</h1>";

try {

    $dsn = "mysql:host=courses;dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style=\"margin-left: 5%; width: 90%; display: table;\">";
    echo "<div style=\"display: table-row; height: 100px;\">";
    echo "<div style=\"width: 30%; display: table-cell;\">";
    echo "<h2 style=\"text-align: center; font-size: 16px; color: #FFA500;\">Queue</h2>";

    # Delete Top From Queue #
    if (isset($_GET['QDelete'])) 
    {
        $ns = $pdo->query("DELETE FROM Queue LIMIT 1");
        header("Location: dj.php");
        exit();
    }

     # Delete Top From Priority Queue #
    if (isset($_GET['PDelete'])) 
    {
        $ns = $pdo->query("DELETE FROM PriorityQueue LIMIT 1");
        header("Location: dj.php");
        exit();     
    }

    # The Queue #
    $rs = $pdo->query("SELECT UNIQUE UserName as User,Queue.FileID as Version,Title,ContributorName as Artist FROM Queue,Song,KaraokeFile,Contributor WHERE Queue.FileID = KaraokeFile.FileID AND Song.SongID = KaraokeFile.SongID AND Queue.FileID = Contributor.FileID AND Role = 'Artist';");

    if ($rs->rowCount() != 0)
    {
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<form style=\"text-align: center;\" action=\"dj.php\" method=\"get\">";
        echo "<input type=hidden name=QDelete value=1>";
        echo "<input style=\"background-color: #FFA500; border: none; color: #363636; font-size:16px;\" value=\"Play Top\" type=\"submit\">";
        echo "</form>";
        draw_table($rows);
    }
    else
    {
        echo "<h2 style=\"text-align: center; font-size: 16px; color: #FFA500;\">No Songs in the Queue</h2>";
    }
    echo "</div>";

    echo "<div style=\"width: 30%; display: table-cell;\">";
    echo "<h2 style=\"text-align: center; font-size: 16px; color: #FFA500;\">Priority Queue</h2>";

    # The PriorityQueue #
    $rs = $pdo->query("SELECT UNIQUE UserName as User,PriorityQueue.FileID as Version,Title,ContributorName as Artist FROM PriorityQueue,Song,KaraokeFile,Contributor WHERE PriorityQueue.FileID = KaraokeFile.FileID AND Song.SongID = KaraokeFile.SongID AND PriorityQueue.FileID = Contributor.FileID AND Role = 'Artist';");

    if ($rs->rowCount() != 0)
    {
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<form style=\"text-align: center;\" action=\"dj.php\" method=\"get\">";
        echo "<input type=hidden name=PDelete value=1>";
        echo "<input style=\"background-color: #FFA500; border: none; color: #363636; font-size:16px;\" value=\"Play Top\" type=\"submit\">";
        echo "</form>";
        draw_table($rows);
    }
    else
    {
        echo "<h2 style=\"text-align: center; font-size: 16px; color: #FFA500;\">No Songs in the Priority Queue</h2>";
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";

} catch(PDOexception $e) {

    echo "Connection to database failed: " . $e->getMessage();

}
echo "</body>";
?>
