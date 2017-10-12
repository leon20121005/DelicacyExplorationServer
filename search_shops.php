<?php
    // Array for JSON response
    $response = array();

    // Include database connection class
    require_once __DIR__ . "/db_connect.php";

    // Connecting to db
    $database = new DBConnection();

    // Get parameters from URL
    $keyword = $_GET["keyword"];

    // Get conditional shops from shops table
    $query = "SELECT shops.*,".
            " thumbnails.url AS thumbnail".
            " FROM shops".
            " LEFT JOIN thumbnails ON shops.id = thumbnails.shop_id".
            " WHERE (shops.name LIKE '%$keyword%' OR shops.address LIKE '%$keyword%')";
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