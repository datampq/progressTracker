<?php
    Header("Cache-Control: no-cache, no-store, must-revalidate");
    class Database
    {
      private static $init = FALSE;
      public static $conn;
      public static function initialize()
      {
        if (self::$init === TRUE)
        return;
        self::$init = TRUE;
        self::$conn = new mysqli("localhost", "datampq", "toor", "drowTracker");
      }
    }
    Database::initialize();
