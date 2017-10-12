<?php
    // Array for JSON response
    $response = array();

    // Include database connection class
    require_once __DIR__ . "/db_connect.php";

    // Connecting to db
    $database = new DBConnection();

    // Get parameters from post data
    $id_list = json_decode($_POST["id_list"]);

    // Create query condition WHERE
    $is_first_element = true;
    $id_list_string = "";
    foreach ($id_list as $id)
    {
        if ($is_first_element)
        {
            $id_list_string .= $id; // Append string
            $is_first_element = false;
        }
        else
        {
            $id_list_string .= (", " . $id);
        }
    }

    // Get conditional thumbs from thumbnails table
    $query = "SELECT *".
            " FROM thumbnails".
            " WHERE shop_id IN ($id_list_string)";
    $result = mysql_query($query);
    if (!$result)
    {
        die("Invalid query: " . mysql_error());
    }

    // Check for empty result
    if (mysql_num_rows($result) > 0)
    {
        // Looping through all results
        // Thumb node
        $response["thumbs"] = array();

        while ($row = mysql_fetch_array($result))
        {
            // Temp for thumb array
            $thumb = array();
            $thumb["shop_id"] = $row["shop_id"];
            $thumb["url"] = $row["url"];

            // Push single thumb into final response array
            array_push($response["thumbs"], $thumb);
        }

        // Success
        $response["success"] = 1;

        // Echoing JSON response
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        // No thumbs found
        $response["success"] = 0;
        $response["message"] = "No thumbs found";

        // Echo no thumbs JSON
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
?>