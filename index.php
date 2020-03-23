<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<body>

<?php
    require( "inc_db_helpers.php" );

    $connhandle = DB_Open( "localhost", "root", "", "overlay" );
    if( isset($_POST) )
    {
	// According to the documentation, you can put multiple parameters in a single isset call; evaluation is from left to right,
	// and returns FALSE at the first instance of failure.
	// Worth testing later.
        if( isset($_POST['FirstName']) && isset($_POST['LastName']) && isset($_POST['submit']) )
        {
            if( $_POST['FirstName'] != "" && $_POST['LastName'] != "" )
            {

		$firstname = $_POST['FirstName'];
		$lastname = $_POST['LastName'];
		$status = $_POST['submit'];

                echo "$firstname $lastname posted $status<br/>\n";
                echo "<br/>\n";

                $firstname = DB_QuoteString( $_POST['FirstName'], $connhandle );
		$lastname = DB_QuoteString( $_POST['LastName'], $connhandle );
                $status = DB_QuoteString( $_POST['submit'], $connhandle );

                $result = DB_Query( "SELECT `ID` FROM `users` WHERE `FirstName` = $firstname AND `LastName` = $lastname", $connhandle );
                if( DB_GetNumRows( $result ) > 0 )
                {
		    $row = $result->fetch_assoc();
		    $id = $row["ID"];
                    $result = DB_Query( "UPDATE `users` SET `Status` = $status, `LastInteraction` = now() WHERE `id` = $id", $connhandle );
                }
                else
                {
		    $name = $firstname[1] . $lastname[1];
		    $name = DB_QuoteString( $name, $connhandle );
                    $result = DB_Query( "INSERT INTO `users` (`FirstName`, `LastName`, `Status`) VALUES ($firstname, $lastname, $status)", $connhandle );
                }
            } elseif (isset($_POST['submit']) ) {
		echo "First and last name required!<br />";
	    }
        }
    }
?>

<form method='post'>
    <?php
    	echo "<label for='FirstName'>First name:</label>";
        echo "<input type='text' name='FirstName' value='" . (isset($_POST['FirstName']) ? $_POST['FirstName'] : "") . "'><br/>\n";
    	echo "<label for='LastName'>Last name:</label>";
        echo "<input type='text' name='LastName' value='" . (isset($_POST['LastName']) ? $_POST['LastName'] : "") . "'><br/>\n";
    ?>
    <input id='Awake-submit' type='submit' name='submit' value='Awake'>
    <input id='Asleep-submit' type='submit' name='submit' value='Asleep'>
    <input id='Question-submit' type='submit' name='submit' value='Question'>
    <input id='Working-submit' type='submit' name='submit' value='Working'>
    <input id='Complete-submit' type='submit' name='submit' value='Complete'>
</form>

</body>
</html>

<?php
    $connhandle = DB_Close( $connhandle );
?>
