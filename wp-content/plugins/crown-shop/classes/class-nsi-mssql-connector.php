<?php

class MSSQLConnector {
    private static $instance = null;
    private $serverName;
    private $username;
    private $password;
    private $schema;
    private $connection;
    private $mode;

    private function __construct($serverName, $username, $password, $schema, $mode) {
        $this->serverName = $serverName;
        $this->username   = $username;
        $this->password   = $password;
        $this->schema     = $schema;
        $this->mode       = $mode;
    }

    public static function get_instance($serverName, $username, $password, $schema, $mode = 'Windows') {
        if (self::$instance === null) {
            self::$instance = new self($serverName, $username, $password, $schema, $mode);
        }
        return self::$instance;
    }

    public function connect() {
        if ($this->mode === 'Windows') {
            $connectionInfo = [
                "UID" => $this->username,
                "PWD" => $this->password,
                "Database" => $this->schema,
                "CharacterSet" => "UTF-8"
            ];
            $this->connection = sqlsrv_connect($this->serverName, $connectionInfo);

            if ($this->connection === false) {
                throw new Exception("SQLSRV Connection failed: " . print_r(sqlsrv_errors(), true));
            }
        } else {
            $dsn = "dblib:host={$this->serverName};dbname={$this->schema};charset=UTF-8";
            try {
                $this->connection = new PDO($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                throw new Exception("PDO_DBLIB Connection failed: " . $e->getMessage());
            }
        }
    }

    public function query_execute($sql, $params = []) {
        if ($this->mode === 'Windows') {
            $stmt = sqlsrv_query($this->connection, $sql, $params);
            if ($stmt === false) {
                throw new Exception("SQLSRV Query failed: " . print_r(sqlsrv_errors(), true));
            }
            $results = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row;
            }
            sqlsrv_free_stmt($stmt);
            return $results;
        } else {
            try {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                throw new Exception("PDO_DBLIB Query failed: " . $e->getMessage());
            }
        }
    }

    public function close() {
        if ($this->mode === 'Windows') {
            if ($this->connection) {
                sqlsrv_close($this->connection);
            }
        } else {
            $this->connection = null;
        }
        self::$instance = null;
    }
}