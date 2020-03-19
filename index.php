<html>
<body>

<?php
    require( "inc_db_helpers.php" );

    $connhandle = DB_Open( "localhost", "root", "", "overlay" );
    if( isset($_POST) )
    {
        echo $_POST['Name'] . " posted " . $_POST['submit'] . "<br/>\n";
        echo "<br/>\n";

        if( isset($_POST['Name']) && isset($_POST['submit']) )
        {
            $name = DB_QuoteString( $_POST['Name'], $connhandle );
            $status = DB_QuoteString( $_POST['submit'], $connhandle );

            $result = DB_Query( "SELECT `ID` FROM `users` WHERE `Name` = $name", $connhandle );
            if( DB_GetNumRows( $result ) > 0 )
            {
                $result = DB_Query( "UPDATE `users` SET `Status` = $status, `LastInteraction` = now() WHERE `name` = $name", $connhandle );
            }
            else
            {
                $result = DB_Query( "INSERT INTO `users` (`Name`, `Status`) VALUES ($name, $status)", $connhandle );
            }
        }
    }
?>

<form method='post'>
    <label for='Name'>Name:</label>
    <?php
        if( isset($_POST) && isset($_POST['Name']) )
        {
            echo "<input type='text' name='Name' value='" . $_POST['Name'] . "'><br/>\n";
        }
        else
        {
            echo "<input type='text' name='Name'><br/>\n";
        }
    ?>
    <input id='Awake-submit' type='submit' name='submit' value='Awake'>
    <input id='Asleep-submit' type='submit' name='submit' value='Asleep'>
    <input id='Question-submit' type='submit' name='submit' value='Question'>
</form>

<body>
</html>

<?php
    $connhandle = DB_Close( $connhandle );
?>
