<?php

function DB_Open($host, $username, $password, $dbname)
{
    $connhandle = mysqli_connect( $host, $username, $password, $dbname )
        or die( 'Cannot connect to the mysql server because: ' . mysqli_error() );

    mysqli_set_charset( $connhandle, 'utf8' );

    return $connhandle;
}

function DB_Query($query, $connhandle)
{
    $result = $connhandle->query( $query )
        or die( '<br/>Error: ' . mysqli_error( $connhandle ) );

    return $result;
}

function DB_GetNumAffectedRows($connhandle)
{
    return mysqli_affected_rows( $connhandle );
}

function DB_GetNumRows($result)
{
    return mysqli_num_rows( $result );
}

function DB_GetNextRow($result)
{
    return mysqli_fetch_array( $result );
}

function DB_ResetResult($result)
{
    mysqli_data_seek( $result, 0 );
}

function DB_FreeResult($result)
{
    mysqli_free_result( $result );
}

function DB_Close($connhandle)
{
    mysqli_close( $connhandle );
}

function DB_EscapeString($string, $connhandle)
{
    return mysqli_real_escape_string( $string );
}

function DB_QuoteString($string, $connhandle)
{
    return "'" . mysqli_real_escape_string( $connhandle, $string ) . "'";
}

function DB_GetLastInsertID($connhandle)
{
    return mysqli_insert_id( $connhandle );
}

function DB_CreateUpdateQuery($table, $values, $condition, $connhandle)
{
    $numvars = sizeof($values);
    $numset = 0;

    $query = "UPDATE `$table` SET";

    foreach( $values as $key => $value )
    {
        if( $key == 'LastUpdated' && $value == 'now()' )
            $query .= " `$key` = $value";
        else
            $query .= " `$key` = " . DB_QuoteString( $value, $connhandle );

        if( $numset < $numvars-1 )
            $query .= ",";

        $numset++;
    }

    $query .= " WHERE $condition";
    //echo $query;

    return $query;
}

?>
