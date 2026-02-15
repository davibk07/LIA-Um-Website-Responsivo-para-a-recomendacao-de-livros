<?php
    define("SERVER", "localhost:3306");
    define("USER", "root");
    define("PASSWORD", "");
    define("DB", "LIA");
    function cria_conexao()
    {
        try
        {
            return new PDO("mysql:host=" . SERVER . ";dbname=" . DB, USER, PASSWORD);
        }
        catch(PDOException $e)
        {
            print("Error: " . $e->getMessage());
        }
    }
?>