<?php
    // Include database connection class
    require_once __DIR__ . "/db_connect.php";

    // Connecting to db
    $database = new DBConnection();

    $id = $_GET["id"];

    $query = "SELECT * FROM images WHERE id = $id";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    header("Content-type: image/jpeg");

    $isAndroid = (strpos($_SERVER["HTTP_USER_AGENT"], "Android") !== false);

    if ($isAndroid)
    {
        echo base64_encode($row["image"]); //如果連線裝置是Android就下載Base64字串
    }
    else
    {
        echo $row["image"]; //如果連線裝置是瀏覽器則顯示圖片
    }
 ?>