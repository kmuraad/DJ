<?php
 # ******************************************
 # - main.php
 # 
 # - Karaoke User Interface
 # - User Selects a Song and Signs Up to Sing
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

    # IF Version and Name IS SET #
    # Display done #
    if (isset($_GET['Name']) && isset($_GET['Version']) && isset($_GET['Donation']))
    {
        if ($_GET['Donation'] <= 0)
            $n = $pdo->query("INSERT INTO Queue (UserName, FileID) VALUES (\"{$_GET['Name']}\", \"{$_GET['Version']}\");");
        else
            $n = $pdo->query("INSERT INTO PriorityQueue (UserName, FileID) VALUES (\"{$_GET['Name']}\", \"{$_GET['Version']}\");");

        echo "<h1 style=\"text-align: center; font-size: 22px; color: #FFFFFF;\">Added to Queue!</h1>";
        echo "<div style=\"display: flex; justify-content: center; align-items: center;\"><a style=\"text-align: center; font-size: 18px; color: #FFA500;\" href=\"https://students.cs.niu.edu/~z1872515/karaoke/main.php\">Back to Home</a></div>";    }
    # IF Version IS SET #
    # Display sign up #
    else if (isset($_GET['Version']))
    {
	    $rs = $pdo->query("SELECT Title,Version,ContributorName,KaraokeFile.FileID 
                           FROM KaraokeFile,Song,Contributor 
                           WHERE Song.SongID = KaraokeFile.SongID 
                           AND Contributor.FileID = KaraokeFile.FileID 
                           AND Role = \"Artist\" 
                           AND KaraokeFile.FileID = \"{$_GET['Version']}\";");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        $song = "Song ";
        
        foreach($rows as $row) {
            foreach($row as $key => $item) {
                $song .= " - ";
                $song .= $item;
            }
        }

        echo "<form style=\"text-align: center;\" action=\"main.php\" method=\"get\">";
        echo "<h2 style=\"text-align: center; font-size: 16px; color: #FFFF00;\">$song</h2>";
        echo "<h3 style=\"text-align: center; font-size: 18px; color: #FFA500;\">Sign up with Your Name</h3>";
        echo "<input type=\"text\" name=\"Name\"><br>";
	echo "<h3 style=\"text-align: center; font-size: 18px; color: #FFA500;\">Donation (Optional)</h3>";
        echo "<input type=\"text\" name=\"Donation\" pattern=\"^[0-9]*$\"><br>";
	echo "<h3 style=\"text-align: center; font-size: 18px; color: #FFA500;\">Version</h3>";
        echo "<input type=\"text\" name=\"Version\" value=\"{$_GET['Version']}\"readonly><br>";
        echo "<input style=\"background-color: #969696;  border: none; color: #363636; font-size:16px;\" type=\"submit\">";
        echo "</form>";
    }
    # IF Contributor IS SET #
    # Display list of songs related to that contributor #
    else if (isset($_GET['Contributor']))
    {
	    $rs = $pdo->query("SELECT UNIQUE Title,Version,ContributorName,KaraokeFile.FileID
                           FROM KaraokeFile,Song,Contributor 
                           WHERE Song.SongID = KaraokeFile.SongID 
                           AND Contributor.FileID = KaraokeFile.FileID 
                           AND ContributorName = \"{$_GET['Contributor']}\"
                           ORDER BY Title;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        
        draw_song_dropdown($rows, "Version");
    }
    # IF Song IS SET #
    # Display list of songs related to that song #
    else if (isset($_GET['Song']))
    {
        $rs = $pdo->query("SELECT Title,Version,ContributorName,KaraokeFile.FileID 
                           FROM KaraokeFile,Song,Contributor 
                           WHERE Song.SongID = KaraokeFile.SongID 
                           AND Contributor.FileID = KaraokeFile.FileID 
                           AND Role = \"Artist\" AND Title = \"{$_GET['Song']}\"
                           ORDER BY Title;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        
        draw_song_dropdown($rows, "Version");
    }
    else
    # Display Search Menu #  
    {
        echo "<div style=\"margin-left: 5%; width: 90%; display: table;\">";
        echo "<div style=\"display: table-row; height: 100px;\">";
        echo "<div style=\"width: 30%; display: table-cell;\">";
        echo "<h2 style=\"color: #FFA500\">Select Song from Contributor</h2>";

        # The List of Contributors #
        $rs = $pdo->query("SELECT UNIQUE ContributorName from Contributor ORDER BY ContributorName;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        draw_dropdown($rows, "Contributor", "Contributor");

        echo "</div>";

        echo "<div style=\"width: 30%; display: table-cell;\">";
        echo "<h2 style=\"color: #FFA500\">Select Song from Title</h2>";

        # The List of Songs #
        $rs = $pdo->query("SELECT Title from Song ORDER BY Title;;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        draw_dropdown($rows, "Song", "Song");

        echo "</div>";

        echo "<div style=\"width: 30%; display: table-cell;\">";
        echo "<h2 style=\"color: #FFA500\">Select Song from Artist</h2>";

        # The List of Artists #
        $rs = $pdo->query("SELECT UNIQUE ContributorName from Contributor WHERE Role =\"Artist\" ORDER BY ContributorName;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        draw_dropdown($rows, "Artist", "Contributor");

        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

} catch(PDOexception $e) {

    echo "Connection to database failed: " . $e->getMessage();

}

echo "</body>";
?>
