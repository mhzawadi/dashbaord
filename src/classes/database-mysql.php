<?php

namespace MHorwood\Dashboard\classes;

use mysqli;

class db_mysql {

    private $host;
    private $user;
    private $pass;
    private $db;
    private $desc;
    public $num_rows;
    private $connection;
    protected $error = 0;
    protected $error_txt = '';

    /**
     * setup MySQL link
     */
    public function __construct($host = '', $user = '', $pass = '', $dbname = '', $port = '3306', $desc = '') {

        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $dbname;
        $this->port = $port;
        $this->desc = $desc;

        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->db, $this->port);
        if ($this->connection->connect_error) {
            die('Connect Error (' . $this->connection->connect_errno . ') ' . $this->connection->connect_error);
        }
    }

    /**
     * run the SQL query, if it fails throw an exeption
     * @param  String $sql
     * @return Boolean
     */
    protected function run_query($sql) {
        $query = $this->connection->query($sql);
        if ($this->connection->errno == 0) {
            return $query;
        } else {
            throw new Exception('SQL Error: ' . $sql);
            $this->error = 1;
            //$this->error_txt = $e->getMessage();
            return $this->connection->error;
        }
    }

    /**
     * Select data
     * @param String $sql
     * @param String $where
     * @param Int $testing
     * @return DB result
     */
    public function select($sql, $assoc = 0, $testing = 0) {
        $this->error = 0;
        if ($testing == 1) {
            echo $sql . ";<br>\n";
        }
        if ((strpos($sql, 'select') == 0) || (strpos($sql, '(select') == 0)) {
            try {
                $results = '';
                $query = $this->run_query($sql);
                if ($assoc === 1) {
                    while ($obj = $query->fetch_assoc()) {
                        $results[] = $obj;
                    }
                } else {
                    while ($obj = $query->fetch_object()) {
                        $results[] = $obj;
                    }
                }
                $this->num_rows = $query->num_rows;
                mysqli_free_result($query);
                if (is_array($results)) {
                    return $results;
                } else {
                    return $this->connection->error;
                }
            } catch (Exception $e) {
                throw new Exception('SQL error: ' . $sql);
                $this->error = 1;
                $this->error_txt = $e->getMessage();
                return $this->connection->error;
            }
        } else {
            return 'Error! not a select statement';
        }
    }

    /**
     *  Insert a new row, but dont return the ID
     * @param String $sql
     * @param Int $testing
     * @return DB result
     */
    function insert($sql, $testing = 0) {
        $this->error = 0;
        if ($testing == 1) {
            echo $sql;
        }
        if (strpos($sql, 'insert into') == 0) {
            try {
                $stmt = $this->connection->prepare($sql);
                if(!$stmt){
                    throw new Exception($this->connection->error);
                }
                return $stmt->execute();
            } catch (Exception $e) {
                $this->error = 1;
                $this->error_txt = $e->getMessage();
                return $this->connection->error;
            }
        } else {
            return 'Error! not an insert  statement';
        }
    }

    /**
     * Insert a new row and return the ID
     * @param String $sql
     * @param Int $testing
     * @return Int
     */
    function new_id($sql, $testing = 0) {
        if (strpos($sql, 'insert into') == 0) {
            if ($testing == 1) {
                return $sql;
            } else {
                try {
                    $this->run_query($sql);
                    return mysql_insert_id();
                } catch (Exception $e) {
                    $this->error = 1;
                    $this->error_txt = $e->getMessage();
                    return $e->getMessage();
                }
            }
        } else {
            return 'Error! not an insert  statement';
        }
    }

    /**
     *
     * @param  String $sql
     * @param  Int $testing
     * @return Boolean
     */
    function update($sql, $testing = 0) {
        if ($testing == 1) {
            echo $sql;
        }
        if (strpos($sql, 'update ') == 0) {
            try {
                $stmt = $this->connection->prepare($sql);
                if(!$stmt){
                    throw new Exception($this->connection->error);
                }
                return $stmt->execute();
            } catch (Exception $e) {
                $this->error = 1;
                $this->error_txt = $e->getMessage();
                return $e->getMessage();
            }
        } else {
            return 'Error! not an update statement';
        }
        return true;
    }

    /**
     * Delete a row
     * @param String $sql
     * @param Int $testing
     * @return Bool
     */
    function delete($sql, $testing = 0) {
        if (strpos($sql, 'delete from ') == 0) {
            if ($testing == 1) {
                return $sql;
            } else {
                try {
                    $this->run_query($sql);
                    return 'deleted';
                } catch (Exception $e) {
                    $this->error = 1;
                    $this->error_txt = $e->getMessage();
                    return $e->getMessage();
                }
            }
        } else {
            return 'Error! not a delete statement';
        }
    }

    public function real_escape_string($string) {
        return $this->connection->real_escape_string($string);
    }

    /**
     * get array of results
     *
     * returns multi-dimensional array
     *     first dimension is number
     *     from second on the values
     *
     * if nothing is provided use assocciative results
     *
     */
    function getArray($query, $assoc = true) {
        /* execute query */
        $result = $this->connection->query($query);

        /* if it failes throw new exception */
        if (mysqli_error($this->connection)) {
            throw new exception(mysqli_error($this->connection), mysqli_errno($this->connection));
        }

        /**
         * fetch array of all access responses
         * either assoc or num, based on input
         *
         */
        if ($assoc == true) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $fields[] = $row;
            }
        } else {
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $fields[] = $row;
            }
        }

        /* return result array */
        if (isset($fields)) {
            return($fields);
        } else {
            $fields = array();
            return $fields;
        }
    }

    public function close() {
        $this->connection->close();
    }

    public function insert_id() {
        return $this->connection->insert_id;
    }

    public function getDesc() {
        return $this->desc;
    }

}
