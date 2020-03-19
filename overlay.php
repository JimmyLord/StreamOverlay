<html>
<head>
    <style type="text/css">
        body
        {
            margin: 0px;
        }
        div
        {
            position: absolute;
            bottom: 0px;
            width: 96%;
            background: red;
            padding: 15px;
        }
    </style>
</head>

<body bgcolor="#00FF00">

<?php

    require( "inc_db_helpers.php" );

    $connhandle = DB_Open( "localhost", "root", "", "overlay" );
    $result = DB_Query( "SELECT `Name`, `Status` FROM `users`", $connhandle );
    $numRows = DB_GetNumRows( $result );

    echo "<div><p>";
    for( $i=0; $i<$numRows; $i++ )
    {
        $row = DB_GetNextRow( $result );
        echo $row["Name"] . " " . $row["Status"] . " ";
        if( $i == 2 )
            echo "<br/>";
    }
    echo "</p></div>";

    DB_FreeResult( $result );
    DB_Close( $connhandle );

?>

</body>

</html>