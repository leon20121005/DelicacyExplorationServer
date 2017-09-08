<?php
    // Array for JSON response
    $response = array();

    // Include database connection class
    require_once __DIR__ . "/db_connect.php";

    // Connecting to db
    $database = new DBConnection();

    // Get parameters from URL
    $shopID = $_GET["shop_id"];

    // Get conditional images from images table
    $query = "SELECT * FROM images WHERE shop_id = $shopID";
    $result = mysql_query($query);
    if (!$result)
    {
        die("Invalid query: " . mysql_error());
    }

    //如果連線裝置是瀏覽器則顯示所有的圖片並結束程式
    $isAndroid = (strpos($_SERVER["HTTP_USER_AGENT"], "Android") !== false);
    if (!$isAndroid)
    {
        while ($row = mysql_fetch_array($result))
        {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row["image"]) . '" />';
        }
        exit();
    }

    //如果連線裝置是Android就透過JSON物件下載所有圖片的Base64字串
    // Check for empty result
    if (mysql_num_rows($result) > 0)
    {
        // Looping through all results
        // Images node
        $response["images"] = array();

        while ($row = mysql_fetch_array($result))
        {
            // Temp for shop array
            $image = array();
            $image["id"] = $row["id"];
            $image["name"] = $row["name"];
            $image["image"] = base64_encode($row["image"]);
            $image["shop_id"] = $row["shop_id"];

            // Push single shop into final response array
            array_push($response["images"], $image);
        }

        // Success
        $response["success"] = 1;

        // Echoing JSON response
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        // No images found
        $response["success"] = 0;
        $response["message"] = "No images found";

        // Echo no images JSON
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
?>