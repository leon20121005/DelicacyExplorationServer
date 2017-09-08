<?php
    // Array for JSON response
    $response = array();

    // Include database connection class
    require_once __DIR__ . "/db_connect.php";

    // Connecting to db
    $database = new DBConnection();

    // Get parameters from URL
    $latitude = $_GET["lat"];
    $longitude = $_GET["lng"];
    $radius = $_GET["radius"];
    $limit = $_GET["limit"];

    // Get conditional shops from shops table. 6371 = earth radius (km)
    $query = "SELECT *,".
            " (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude))))".
            " AS distance".
            " FROM shops".
            " HAVING distance < $radius".
            " ORDER BY distance".
            " LIMIT 0, $limit";
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
            $shop["created_at"] = $row["created_at"];
            $shop["updated_at"] = $row["updated_at"];

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