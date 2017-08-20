<?php
    define('DB_USER', "root"); //資料庫使用者
    define('DB_PASSWORD', ""); //資料庫密碼
    define('DB_DATABASE', "android_test"); //資料庫名字
    define('DB_SERVER', "localhost"); //資料庫伺服器

    class DB_CONNECT
    {
        //Constructor
        function __construct()
        {
            $this -> connect();
        }

        //Destructor
        function __destruct()
        {
            $this -> close();
        }

        //連接至資料庫
        function connect()
        {
            //Connecting to mysql database
            $connect = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());

            //Set encoding to UTF-8
            mysql_query("SET NAMES UTF8");

            //Selecing database
            $database = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());

            //Returing connection cursor
            return $connect;
        }

        //關閉至資料庫的連接
        function close()
        {
            //Closing db connection
            mysql_close();
        }
    }
?>