<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="3"> <!-- Refresh every 3 seconds -->
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="master.css" />
    <link rel="stylesheet" type="text/css" href="style1.css" />
</head>

<body>

<?php
    require( "inc_db_helpers.php" );

    $connhandle = DB_Open( "localhost", "root", "", "overlay" );
    $result = DB_Query( "SELECT `FirstName`, `LastName`, `Status` FROM `users` WHERE LastInteraction > DATE_SUB(NOW(), INTERVAL 3 HOUR)", $connhandle );
    $numRows = DB_GetNumRows( $result );

    echo "<div id=\"overlay\">";
    echo "<div class=\"row\">";
    for( $i=0; $i<$numRows; $i++ )
    {
        $row = DB_GetNextRow( $result );
        $status_output = "??";
        $status_class = "error";

        switch( $row["Status"] )
        {
            case "Awake":
                $status_output = "&#9679;";
                $status_class = "awake";
                break;
            case "Asleep":
                $status_output = "&#9675;";
                $status_class = "asleep";
                break;
            case "Question":
                $status_output = "&iquest;&quest;";
                $status_class = "question";
                break;
            case "Complete":
                $status_output = "&radic;";
                $status_class = "complete";
                break;
            case "Working":
                $status_output = "&mldr;&mldr;";
                $status_class = "working";
                break;
            default:
                $status_output = $row["Status"];
                $status_class = "other";
                break;
        }
        $formattedname = $row["FirstName"] . " " . $row["LastName"];
        $abbreviatedname = substr($row["FirstName"], 0, 1) . substr($row["LastName"], 0, 1);
        if( $formattedname == " " )
        {
            $formattedname = "Undef";
            $abbreviatedname = "UN";
        }
        echo "<span class=\"student\"><span title=\"" . $formattedname . "\">" . $abbreviatedname . "</span> <span class=\"$status_class\">" . $status_output . "</span></span>\n";

        // Max 15 users on each line.
        if( $i % 15 == 14 )
            echo "</div>\n<div class=\"row\">";
    }
    echo "</div></div>";

    DB_FreeResult( $result );
    DB_Close( $connhandle );

?>

</body>

</html>
