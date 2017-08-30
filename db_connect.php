<?php
    define('DB_USER', "root"); //資料庫使用者
    define('DB_PASSWORD', ""); //資料庫密碼
    define('DB_DATABASE', "android_test"); //資料庫名字
    define('DB_SERVER', "localhost"); //資料庫伺服器

    class DBConnection
    {
        // Constructor
        function __Construct()
        {
            $this -> Connect();
        }

        // Destructor
        function __Destruct()
        {
            $this -> Close();
        }

        //連接至資料庫
        function Connect()
        {
            // Connect to the mysql server
            $connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
            if (!$connection)
            {
                die("Not connected: " . mysql_error());
            }

            // Set encoding to UTF-8
            mysql_query("SET NAMES UTF8");

            // Select the active database
            $isSelected = mysql_select_db(DB_DATABASE);
            if (!$isSelected)
            {
                die("Can not use database: " . mysql_error());
            }

            // Return the connection cursor
            return $connection;
        }

        //關閉至資料庫的連接
        function Close()
        {
            // Close database connection
            mysql_close();
        }
    }
?>