<?php

class Conexion {
    private $host = "localhost";
    private $db = "bdcarritocompras";
    private $user = "root"; // ¡Cuidado, cambia esto en producción!
    private $pass = "";     // ¡Cuidado, cambia esto en producción!
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8",
                $this->user,
                $this->pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método genérico para ejecutar consultas (SELECT)
    public function ejecutarConsulta($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Otros métodos (ejecutarComando, etc.) irían aquí...
}