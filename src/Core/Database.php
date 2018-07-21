<?php

namespace Core;

use \PDO as PDO;

class Database
{
    protected static $instance;
    protected $pdo;

    protected function __construct()
    {
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function select($table, $columns = null, $where = null, $order = null, $limit = null)
    {
        if (is_array($columns)) {
            $columns = '`' . implode('`,`', $columns) . '`';
        } else {
            $columns = '*';
        }

        $params = array();
        if (is_array($where)) {
            $sql_where = 'WHERE ';

            foreach ($where as $key => $value) {
                $sql_where .= '`' . $key . '` = :' . $key;
                $params[$key] = $value;
            }
        } else {
            $sql_where = '';
        }

        $sql = "
            SELECT {$columns}
              FROM {$table}
             {$sql_where}
        ";

        $sth = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $sth->bindParam(':' . $key, $value);
        }

        $sth->execute();

        return $sth->fetchAll();

    }

    public function selectIn($table, $columns = null, $where = null, $order = null, $limit = null)
    {
        if (is_array($columns)) {
            $columns = '`' . implode('`,`', $columns) . '`';
        } else {
            $columns = '*';
        }

        $params = array();
        if (is_array($where)) {
            $sql_where = 'WHERE ';

            foreach ($where as $key => $values) {
                $sql_where .= '`' . $key . '` IN (?' . str_repeat(', ?', count($values) - 1) . ')';
                $params = array_merge($params, $values);
            }
        } else {
            $sql_where = '';
        }

        $sql = "
            SELECT {$columns}
              FROM {$table}
             {$sql_where}
        ";

        $sth = $this->pdo->prepare($sql);

        $sth->execute($params);

        return $sth->fetchAll();
    }

}
