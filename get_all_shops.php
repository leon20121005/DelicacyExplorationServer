<?php
    //Array for JSON response
    $response = array();

    //Include db connect class
    require_once __DIR__ . '/db_connect.php';

    //Connecting to db
    $database = new DB_CONNECT();

    //Get all shops from shops table
    $result = mysql_query("SELECT * FROM shops") or die(mysql_error());

    //Check for empty result
    if (mysql_num_rows($result) > 0)
    {
        //Looping through all results
        //Shops node
        $response["shops"] = array();

        while ($row = mysql_fetch_array($result))
        {
            //Temp for shop array
            $shop = array();
            $shop["id"] = $row["id"];
            $shop["name"] = $row["name"];
            $shop["evaluation"] = $row["evaluation"];
            $shop["address"] = $row["address"];
            $shop["created_at"] = $row["created_at"];
            $shop["updated_at"] = $row["updated_at"];

            //Push single shop into final response array
            array_push($response["shops"], $shop);
        }

        //Success
        $response["success"] = 1;

        //Echoing JSON response
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        //No shops found
        $response["success"] = 0;
        $response["message"] = "No shops found";

        //Echo no shops JSON
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
?>