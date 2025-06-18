<?php
class Connection
{
   private static string $DB_SERVER = 'localhost';
   private static string $DB_USER = 'root';
   private static string $DB_PASSWORD = '';
   private static string $DB_NAME = 'db_phpeso';

   private static ?Connection $instance = null;
   private static ?PDO $connection = null;

   private function __construct()
   {
   }

   public static function getInstance(): Connection
   {
      if (self::$instance === null) {
         self::$instance = new Connection();
      }
      return self::$instance;
   }

   public function getConnection(): ?PDO
   {
      if (self::$connection === null) {
         try {
            $dsn = "mysql:host=" . self::$DB_SERVER . ";dbname=" . self::$DB_NAME . ";charset=utf8";
            self::$connection = new PDO($dsn, self::$DB_USER, self::$DB_PASSWORD);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return null;
         }
      }

      return self::$connection;
   }
}
