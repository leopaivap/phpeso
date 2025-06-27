<?php
class Connection
{
   //    private static string $DB_SERVER = 'localhost';
//    private static string $DB_USER = 'root';
//    private static string $DB_PASSWORD = '';
//    private static string $DB_NAME = 'db_phpeso';

   function getDatabaseConfig()
   {
      return [
         'db_server' => getenv('DB_SERVER') ?? 'mysql' ?? 'localhost',
         'db_name' => getenv('DB_NAME') ?: 'db_phpeso',
         'db_user' => getenv('DB_USER') ?: 'root',
         'db_password' => getenv('DB_PASSWORD') ?: '',
         'db_options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
         ]
      ];
   }

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
      $db_config = $this->getDatabaseConfig();
      if (self::$connection === null) {
         try {
            $dsn = "mysql:host=" . $db_config['db_server'] . ";dbname=" . $db_config['db_name'] . ";charset=utf8";
            self::$connection = new PDO($dsn, $db_config['db_user'], $db_config['db_password'], $db_config['db_options']);
         } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return null;
         }
      }

      return self::$connection;
   }
}
