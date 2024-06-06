<?php

namespace Table;

use PDO;
use PDOException;

class DB {
    protected $table;
    protected $connection;
    protected $where = [];
    protected $orderBy;
    protected $limit;
    protected $join;
    protected $select;

    public function __construct($table, $connection = null) {
        $this->table = $table;
        $this->connection = $connection ?? new PDO("mysql:host=localhost;dbname=restourantorderingsystem", "root", "");
    }

    public static function table($table) {
        return new self($table);
    }

    public function where($column, $operator, $value = "") {
        if(!$value){
            $value = $operator;
            $operator = "=";
        }
        $this->where[] = [$column, $operator, $value];
        return $this;
    }

    public function orderBy($column, $direction = 'asc') {
        $this->orderBy = [$column, $direction];
        return $this;
    }

    public function join($table, $firstColumn, $operator, $secondColumn) {
        $this->join[] = [$table, $firstColumn, $operator, $secondColumn];
        return $this;
    }

    public function select($columns) {
        $this->select = $columns;
        return $this;
    }
     

    public function get() {
        try {
            $sql = "SELECT ";
    
            if (!empty($this->select)) {
                $sql .= implode(', ', $this->select);
            } else {
                $sql .= "*";
            }
    
            $sql .= " FROM {$this->table}";
    
            if (!empty($this->join)) {
                foreach ($this->join as $join) {
                    $sql .= " JOIN {$join[0]} ON {$this->table}.{$join[1]} {$join[2]} {$join[0]}.{$join[3]}";
                }
            }
    
            if (!empty($this->where)) {
                $sql .= " WHERE ";
                foreach ($this->where as $key => $condition) {
                    if ($key !== 0) {
                        $sql .= " AND ";
                    }
                    $sql .= "{$condition[0]} {$condition[1]} ?";
                }
            }
    
            if (!empty($this->orderBy)) {
                $sql .= " ORDER BY {$this->orderBy[0]} {$this->orderBy[1]}";
            }
    
            if (!empty($this->limit)) {
                $sql .= " LIMIT {$this->limit}";
            }
    
            $statement = $this->connection->prepare($sql);
            $params = array_map(function($condition) {
                return $condition[2];
            }, $this->where);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Veritabanı hatası: " . $e->getMessage());
        }
    }
    
    

    public function first() {
        $this->limit = 1;
        $result = $this->get();
        return isset($result[0]) ? $result[0] : null;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function insert($data) {
        try {
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $statement = $this->connection->prepare($sql);

            $i = 1;
            foreach ($data as $value) {
                $statement->bindValue($i++, $this->filter($value));
            }

            $statement->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            die("Veritabanı hatası: " . $e->getMessage());
        }
    }

    public function delete() {
        try {
            $sql = "DELETE FROM {$this->table}";

            if (!empty($this->where)) {
                $sql .= " WHERE ";
                foreach ($this->where as $key => $condition) {
                    if ($key !== 0) {
                        $sql .= " AND ";
                    }
                    $sql .= "{$condition[0]} {$condition[1]} ?";
                }
            }

            $statement = $this->connection->prepare($sql);
            $params = array_map(function($condition) {
                return $condition[2];
            }, $this->where);
            $statement->execute($params);
            return $statement->rowCount();
        } catch (PDOException $e) {
            die("Veritabanı hatası: " . $e->getMessage());
        }
    }

    public function update($data = []) {
        if(empty($data)) {
            die("Güncelleme verisi belirtilmedi. Doğru kullanım: MyORM::table('products')->update(['column_name' => 'new_value']);");
        }
        try {
            $sql = "UPDATE {$this->table} SET ";

            foreach ($data as $key => $value) {
                $sql .= "{$key} = ?, ";
            }
            $sql = rtrim($sql, ', ');

            if (!empty($this->where)) {
                $sql .= " WHERE ";
                foreach ($this->where as $key => $condition) {
                    if ($key !== 0) {
                        $sql .= " AND ";
                    }
                    $sql .= "{$condition[0]} {$condition[1]} ?";
                }
            }

            $statement = $this->connection->prepare($sql);
            $params = array_merge(array_values($data), array_map(function($condition) {
                return $condition[2];
            }, $this->where));
            $statement->execute($params);
            return $statement->rowCount();
        } catch (PDOException $e) {
            die("Veritabanı hatası: " . $e->getMessage());
        }
    }

    public function truncate() {
        try {
            $sql = "TRUNCATE TABLE {$this->table}";
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            die("Veritabanı hatası: " . $e->getMessage());
        }
    }

    public function filter($value) {
        $filterValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $filterValue = addslashes($filterValue);
        return $filterValue;
    }

}
