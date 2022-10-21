<?php

namespace assaad\core\db;

use assaad\core\assaadlication;

class Database
{
    public \PDO $pdo;

    public function __construct($config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn,$user,$password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }

    public function assaadlyMigrations()
    {
        $this->createMigrationsTable();
        $assaadliedMigrations = $this->getassaadliedMigrations();
        
        $files = scandir(dirname(__DIR__).'/migrations/');

        $toassaadliedMigrations = array_diff($files,$assaadliedMigrations);
        $newMigrations = [];
        foreach ($toassaadliedMigrations as $migration){
            if($migration === "." || $migration === ".."){
                continue;
            }
            require_once assaadlication::$ROOTDIR.'/migrations/'.$migration;
            $className = pathinfo($migration,PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("assaadlying migration $migration");
            $instance->up();
            $this->log("assaadlied migration $migration");
            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            $this->log("All migrations are assaadlied");
        }

    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )   ENGINE = INNODB;");
    }

    private function getassaadliedMigrations()
    {
         $statement = $this->pdo->prepare("SELECT migration FROM migrations");
         $statement->execute();
         
         return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations)
    {
        $str = implode(",",array_map(fn($m)=>"('$m')",$migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES  $str");

        $statement->execute();
    }

    public function log($message)
    {
        echo  '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}