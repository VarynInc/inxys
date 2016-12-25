<?php

/**
 * Created by PhpStorm.
 * User: jf
 * Date: 12/25/2016
 * Time: 10:03 AM
 */
require_once('config.php');

class database
{
    private $dbConnectionTable = array();
    private $lastDBConnectionName = null;
    private $sqlDBs;

    function __construct ($whichDatabase = ACTIVE_DATABASE, $closeOld = true) {
        $this->connect($whichDatabase, $closeOld);
    }

    function __destruct () {
        $this->closeAll();
    }

    public function connect ($whichDatabase = ACTIVE_DATABASE, $closeOld = true) {
        $currentDBConnection = null;
        if (isset($this->dbConnectionTable[$whichDatabase])) {
            $currentDBConnection = $this->dbConnectionTable[$whichDatabase];
        }
        if ($currentDBConnection != null && $closeOld) {
            $this->close($currentDBConnection);
            $currentDBConnection = null;
            $this->dbConnectionTable[$whichDatabase] = $currentDBConnection;
            if ($this->lastDBConnectionName == $whichDatabase) {
                $this->lastDBConnectionName = null;
            }
        }
        if ($currentDBConnection == null) {
            $errorLevel = error_reporting(); // TODO: turn off warnings so we don't generate crap in the output stream (I cant get this to work anyway)
            error_reporting($errorLevel & ~E_WARNING);
            $sqlDB = &$sqlDBs[$whichDatabase];
            try {
                $currentDBConnection = new PDO('mysql:host=' . $sqlDB['host'] . ';dbname=' . $sqlDB['db'], $sqlDB['user'], $sqlDB['password']);
                $currentDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $currentDBConnection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            } catch(PDOException $e) {
                $this->reportError('Error exception connecting to server ' . $sqlDB['host'] . ', ' . $sqlDB['user'] . ', ' . $sqlDB['password'] . ', ' .$sqlDB['db'] . ', ' .$sqlDB['port'] . ': ' . $e->getMessage());
            }
            if ($currentDBConnection == null) {
                $this->reportError('Database connection failed: Host=' . $sqlDB['host'] . '; User=' . $sqlDB['user'] . '; Pass=' . $sqlDB['password'] . '; DB=' . $sqlDB['db'] . '; Port=' . $sqlDB['port']);
            } else {
                $this->dbConnectionTable[$whichDatabase] = $currentDBConnection;
                $this->lastDBConnectionName = $whichDatabase;
            }
            error_reporting($errorLevel); // put error level back to where it was
        } else {
            $this->lastDBConnectionName = $whichDatabase;
        }
        return $currentDBConnection;
    }

    public function query ($sqlCommand, $parametersArray = null) {
        $sql = null;
        if ($parametersArray == null) {
            $parametersArray = array();
        }
        if ( ! is_array($parametersArray)) {
            $this->reportError('dbQuery invalid query with ' . $sqlCommand);
            $parametersArray = array($parametersArray);
        }
        $lastDBConnection = $this->getActiveConnection();
        if ($lastDBConnection != null) {
            try {
                $sql = $lastDBConnection->prepare($sqlCommand);
                $sql->setFetchMode(PDO::FETCH_BOTH);
                $sql->execute($parametersArray);
            } catch(PDOException $e) {
                $this->reportError('dbQuery exception ' . $e->getMessage() . ' for ' . $sqlCommand . ', params ' . implode(',', $parametersArray));
            }
        } else {
            $this->reportError('dbQuery called with no DB connection for ' . $sqlCommand);
        }
        return $sql;
    }

    public function exec ($sqlCommand, $parametersArray = null) {
        if ($parametersArray == null) {
            $parametersArray = array();
        }
        $lastDBConnection = $this->getActiveConnection();
        $sql = $lastDBConnection->prepare($sqlCommand);
        $sql->execute($parametersArray);
        return $sql;
    }

    public function fetch ($result) {
        $resultSet = null;
        if ($result != null) {
            $errorLevel = error_reporting(); // TODO: turn off warnings so we don't generate crap in the output stream (I cant get this to work anyway)
            error_reporting($errorLevel & ~E_WARNING);
            try {
                $resultSet = $result->fetch(PDO::FETCH_BOTH);
            } catch (PDOException $e) {
                if ($result->errorCode() !== 'HY000') {
                    $this->reportError('dbFetch Error exception ' . $e->getMessage() . ' on ' . $result->queryString);
                }
            }
            error_reporting($errorLevel); // put error level back to where it was
        }
        return $resultSet;
    }

    public function fetchAll ($result) {
        $resultSet = null;
        if ($result != null) {
            try {
                $resultSet = $result->fetchAll(PDO::FETCH_BOTH);
            } catch (PDOException $e) {
                if ($result->errorCode() !== 'HY000') {
                    $this->reportError('dbFetchAll Error exception ' . $e->getMessage() . ' on ' . $result->queryString);
                }
            }
        }
        return $resultSet;
    }

    public function rowCount ($result) {
        return $result == null ? null : $result->rowCount();
    }

    public function nextResult ($result) {
        return $result == null ? null : $result->nextRowset();
    }

    public function errorCode ($db) {
        // $db can be either a database handle or a results object
        $errorCode = null; // no error
        if ($db != null) {
            $errorInfo = $db->errorInfo();
            if ($errorInfo != null && count($errorInfo) > 1 && $errorInfo[1] != 0) {
                $errorCode = $errorInfo[2];
            }
        } else {
            $db = $this->getActiveConnection();
            if ($db == null) {
                // general error no database connection
                $errorCode = 'Database connection error.';
            } else {
                $errorCode = $this->errorCode($db);
            }
        }
        return $errorCode;
    }

    public function lastInsertId () {
        $lastDBConnection = $this->getActiveConnection();
        $lastId = 0; // error
        if ($lastDBConnection != null) {
            $lastId = $lastDBConnection->lastInsertId();
        }
        return $lastId;
    }

    public function getActiveConnection ($whichDatabase = null) {
        $currentDBConnection = null;
        if ($whichDatabase == null) {
            $whichDatabase = $this->lastDBConnectionName;
            if ($whichDatabase == null) {
                $whichDatabase = ACTIVE_DATABASE;
            }
        }
        if (isset($this->dbConnectionTable[$whichDatabase])) {
            $currentDBConnection = $this->dbConnectionTable[$whichDatabase];
        }
        if ($currentDBConnection == null) {
            $currentDBConnection = $this->connect($whichDatabase);
        }
        return $currentDBConnection;
    }

    public function isActiveConnection ($whichDatabase = null) {
        $isActive = false;
        if ($whichDatabase == null) {
            $whichDatabase = $this->lastDBConnectionName;
            if ($whichDatabase == null) {
                $whichDatabase = ACTIVE_DATABASE;
            }
        }
        if (isset($this->dbConnectionTable[$whichDatabase])) {
            $isActive = $this->dbConnectionTable[$whichDatabase] != null;
        }
        return $isActive;
    }

    public function close ($whichDatabaseConnection = null) {
        $dbConnectionName = null;
        if ($whichDatabaseConnection == null) {
            $whichDatabaseConnection = $this->dbConnectionTable[$this->lastDBConnectionName];
            $dbConnectionName = $this->lastDBConnectionName;
        } else {
            foreach ($this->dbConnectionTable as $whichDatabase => $dbConn) {
                if ($dbConn == $whichDatabaseConnection) {
                    $dbConnectionName = $whichDatabase;
                }
            }
        }
        $whichDatabaseConnection = null;
        if ($dbConnectionName != null) {
            $this->dbConnectionTable[$dbConnectionName] = null;
            if ($this->lastDBConnectionName == $dbConnectionName) {
                $this->lastDBConnectionName = null;
            }
        }
    }

    public function closeAll () {
        foreach ($this->dbConnectionTable as $whichDatabase => $currentDBConnection) {
            if ($currentDBConnection != null) {
                $currentDBConnection = null;
                $this->dbConnectionTable[$whichDatabase] = null;
            }
        }
        $this->lastDBConnectionName = null;
    }

    public function clearResults ($sqlResults) {
        if ($sqlResults != null) {
            $sqlResults->closeCursor();
        }
    }

    public function fieldInfo($result, $fieldIndex) {
        if ($result == null) {
            return null;
        }
        return $result->getColumnMeta($fieldIndex);
    }

    public function getObjectArray($query, $parameters, $ret_obj_array) {
        // convert the query results array into an array of objects
        $lastDBConnection = $this->getActiveConnection();
        $result = $this->query($query, $parameters);
        if ($result == null) {
            $this->reportError('dbGetObjectArray error: ' . $this->errorCode($lastDBConnection) . '<br/>' . $query . '<br/>');
        } else {
            for ($i = 0; $i < $this->rowCount($result); $i ++ ) {
                $row = $this->fetch($result);
                $row_obj = ((object)NULL);
                foreach ($row as $key => $value) {
                    $row_obj->{$key} = $value;
                }
                $ret_obj_array[$i] = $row_obj;
            }
        }
        return $ret_obj_array;
    }

    public function dateToMySQLDate ($phpDate) {
        // Convert php Date or a date string to MySQL date
        if (is_null($phpDate)) {
            return date('Y-m-d H:i:s', time()); // no date given, use now
        } elseif (is_string($phpDate)) {
            return date('Y-m-d H:i:s', strtotime($phpDate));
        } else {
            return date('Y-m-d H:i:s', $phpDate);
        }
    }

    public function mySQLDateToDate ($mysqlDate) {
        // Convert MySQL date to php Date
        return strtotime($mysqlDate);
    }

    public function mySQLDateToHumanDate ($mysqlDate) {
        // MySQL date is YYYY-mm-dd convert it to mm/dd/yyyy
        return substr($mysqlDate, 5, 2) . '/' . substr($mysqlDate, 8, 2) . '/' . substr($mysqlDate, 0, 4);
    }

    public function humanDateToMySQLDate ($humanDate) {
        // Convert mm/dd/yyyy into yyyy-mm-dd
        $dateParts = explode('/', $humanDate, 3);
        if(strlen($dateParts[0]) < 2) {
            $dateParts[0] = '0' . $dateParts[0];
        }
        if(strlen($dateParts[1]) < 2) {
            $dateParts[1] = '0' . $dateParts[1];
        }
        if(strlen($dateParts[2]) < 3) {
            if ((int) $dateParts[2] < 76) { // we are having Y2K issues
                $dateParts[2] = '20' . $dateParts[2];
            } else {
                $dateParts[2] = '19' . $dateParts[2];
            }
        }
        return $dateParts[2] . '-' . $dateParts[0] . '-' . $dateParts[1] . ' 00:00:00';
    }

    private function reportError($message) {
    }
}