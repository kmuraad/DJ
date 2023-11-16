<?php
# CONTRIBUTOR/SONG DROP DOWN MENU #
function draw_dropdown($rows, $type, $info)
{
    echo "<div style=\"margin-left: 10%; width: 80%; display: table; margin: auto;\">";
    echo "<div style=\"display: table-row; height: 100px;\">";
    echo "<div style=\"width: 40%; display: table-cell;\">";

    echo "<div class=\"dropdown\" style=\"display: flex; justify-content: center; align-items: center;\">";
    echo "<button class=\"dropbtn\">$type</button>";
    echo "<div class=\"dropdown-content\">";

    foreach($rows as $row) {
        foreach($row as $key => $item) {
            $link = '?' . $info . '=' . $item;
            echo "<a href=\"$link\">$item</a>";
        }
    }
    echo "</div>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
}

# VERSION DROP DOWN MENU #
# Shows list of versions based on given contributor or song #
function draw_song_dropdown($rows, $type)
{
    echo "<div style=\"margin-left: 10%; width: 80%; display: table; margin: auto;\">";
    echo "<div style=\"display: table-row; height: 100px;\">";
    echo "<div style=\"width: 40%; display: table-cell;\">";

    echo "<div class=\"dropdown\" style=\"display: flex; justify-content: center; align-items: center;\">";
    echo "<button class=\"dropbtn\">$type</button>";
    echo "<div class=\"dropdown-content\">";

    $num = 1;

    foreach($rows as $row) {

        $link = "$num";
        $id = "";

        foreach($row as $key => $item) {
            $link .= " - ";
            $link .= $item;
            $id = '?' . $type . '=' . $item;
        }
        echo "<a href=\"$id\">$link</a>";   
        $num++;
    }
    echo "</div>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
}

# QUEUE TABLE #
# Shows list of people in queue #
function draw_table($rows) {
    echo "<table style=\"background-color: #FFFF00; margin-left: auto; margin-right: auto;\">";
    echo "<tr>";    

    foreach($rows[0] as $key => $item) {
        echo "<th>$key</th>";
    }
    echo "</tr>";

    foreach($rows as $row) {
        echo "<tr>";

        foreach($row as $key => $item) {
            echo "<td>$item</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>