<?php
    // Array for JSON response
    $response = array();

    // Include database connection class
    require_once __DIR__ . "/db_connect.php";

    // Connecting to db
    $database = new DBConnection();

    // Get parameters from post data
    $id_list = json_decode($_POST["id_list"]);
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $order = $_POST["order"];

    // Create query condition WHERE
    $is_first_element = true;
    $id_list_string = "";
    foreach ($id_list as $id)
    {
        if ($is_first_element)
        {
            $id_list_string .= $id;
            $is_first_element = false;
        }
        else
        {
            $id_list_string .= (", " . $id);
        }
    }

    // Get conditional shops from shops table. 6371 = earth radius (km)
    if ($order == "distance")
    {
        $query = "SELECT shops.*,".
                " (6371 * acos(cos(radians($latitude)) * cos(radians(shops.latitude)) * cos(radians(shops.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(shops.latitude))))".
                " AS distance,".
                " thumbnails.url AS thumbnail,".
                " comments.url AS comment".
                " FROM shops".
                " LEFT JOIN thumbnails ON shops.id = thumbnails.shop_id".
                " LEFT JOIN comments ON shops.id = comments.shop_id".
                " WHERE shops.id IN ($id_list_string)".
                " ORDER BY $order";
    }
    else
    {
        $query = "SELECT shops.*,".
                " thumbnails.url AS thumbnail,".
                " comments.url AS comment".
                " FROM shops".
                " LEFT JOIN thumbnails ON shops.id = thumbnails.shop_id".
                " LEFT JOIN comments ON shops.id = comments.shop_id".
                " WHERE shops.id IN ($id_list_string)".
                " ORDER BY $order";
    }

    $result = mysql_query($query);
    if (!$result)
    {
        die("Invalid query: " . mysql_error());
    }

    // Check for empty result
    if (mysql_num_rows($result) > 0)
    {
        // Looping through all results
        // Shops node
        $response["shops"] = array();

        while ($row = mysql_fetch_array($result))
        {
            // Temp for shop array
            $shop = array();
            $shop["id"] = $row["id"];
            $shop["name"] = $row["name"];
            $shop["evaluation"] = $row["evaluation"];
            $shop["address"] = $row["address"];
            $shop["latitude"] = $row["latitude"];
            $shop["longitude"] = $row["longitude"];

            if ($row["thumbnail"] != null)
            {
                $shop["thumbnail"] = $row["thumbnail"];
            }
            else
            {
                $shop["thumbnail"] = "null";
            }

            $shop["comment"] = $row["comment"];

            // Push single shop into final response array
            array_push($response["shops"], $shop);
        }

        // Success
        $response["success"] = 1;

        // Echoing JSON response
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        // No shops found
        $response["success"] = 0;
        $response["message"] = "No shops found";

        // Echo no shops JSON
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
?>