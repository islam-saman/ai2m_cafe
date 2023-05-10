<?php 
class Database
{
    private string $dbHost = "127.0.0.1";
    private int $dbPort = 3306;
    private string $dbUser;
    private string $dbPass;
    private string $dbName;
    private $dbConnection;

    function __construct(string $dbUser, string $dbPass, string $dbName)
    {
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->connect();

    }
    private function connect()
    {
        try
        {
            $dbURL = "mysql:dbname=$this->dbName;host=$this->dbHost;port=$this->dbPort";
            $this->dbConnection = new PDO($dbURL, $this->dbUser, $this->dbPass);   
            return $this->dbConnection;
        }
        catch(Exception $dbConError)
        {
            return $dbConError->getMessage();
        }
    }


    public function fetchALl($tableName,string $select="*")
    {
        if (!$this->connect())
            throw new Exception;
        

        $selectQuery = "SELECT $select FROM $tableName";
        $selectStatement = $this->dbConnection->prepare($selectQuery);
        $selectStatement->execute();        

        if($selectStatement->rowCount() != 0)
            return $selectStatement->fetchALl(PDO::FETCH_ASSOC);
        else
            return [];     
    }
    


    // If we have time, we must let the user of the function to decide the desired fields
    public function  fetchOne(string $tableName, string $primaryKey, string $value)
    {
        if (!$this->connect())
            throw new Exception;

        $selectQuery = "SELECT * FROM `$tableName` where $primaryKey = '{$value}'";
        $selectStatement = $this->dbConnection->prepare($selectQuery);
        $selectStatement->execute();        

        if($selectStatement->rowCount() != 0)
            return $selectStatement->fetch(PDO::FETCH_ASSOC);
        else
            return null;

    }


    public function getLastRow(string $tableName,array $columns, array $columnsValue){
        if (!$this->connect())
            throw new Exception;

        $rowColumns = "";
        foreach($columns as $column)
        {
            if($rowColumns == "")
                $rowColumns .= $column;
            else
                $rowColumns .= ",".$column;
        }

        // we could achive this in just one for loop, but I sepreate them to be very clear for me when reading the code again
        $rowValues = "";
        foreach($columnsValue as $value)
        {
            if($rowValues == "")
                $rowValues .= "'{$value}'";
            else
                $rowValues .= ","."'{$value}'";
        }

        $insrtQuery = "INSERT INTO `$tableName` ($rowColumns) values ($rowValues)";
        $insetStatement = $this->dbConnection->prepare($insrtQuery);
        $insetStatement->execute();

        if($insetStatement->rowCount())
            return $this->dbConnection->lastInsertId();
        else
            return false;
    }



    // public function insert(string $tableName, array $columns, array $columnsValue)
    public function fetchLastRow(string $tableName)
    {
        if (!$this->connect())
            throw new Exception;
            

        $selectQuery = "SELECT * FROM $tableName ORDER BY id DESC LIMIT 1";
        $selectStatement = $this->dbConnection->prepare($selectQuery);
        $selectStatement->execute();        

        if($selectStatement->rowCount() != 0)
            return $selectStatement->fetch(PDO::FETCH_ASSOC);
        else
            return null;

    }

    public function insert(string $tableName, array $columns, array $columnsValue)
    {
        // if (!$this->connect())
        //     throw new Exception;

        $rowColumns = "";
        foreach($columns as $column)
        {
            if($rowColumns == "")
                $rowColumns .= $column;
            else
                $rowColumns .= ",".$column;
        }

        // we could achive this in just one for loop, but I sepreate them to be very clear for me when reading the code again
        $rowValues = "";
        foreach($columnsValue as $value)
        {
            if($rowValues == "")
                $rowValues .= "'{$value}'";
            else
                $rowValues .= ","."'{$value}'";
        }

        $insrtQuery = "INSERT INTO `$tableName` ($rowColumns) values ($rowValues)";
        $insetStatement = $this->dbConnection->prepare($insrtQuery);
        $insetStatement->execute();
        
        if($insetStatement->rowCount())
            return true;
        else
            return false;
    }


    public function updateById(string $tableName, array $columns, array $columnsValue, string $id)
    {
        if (!$this->connect())
            throw new Exception;

        $prepareSet = "";
        for($index = 0; $index < count($columns); $index++)
        {
            if($index === 0)
            {
                $prepareSet .= "$columns[$index] = '$columnsValue[$index]'";
            }
            else
            {
                $prepareSet .= ","."$columns[$index] = '$columnsValue[$index]'";   
            }
        }

        $updateQuery = "UPDATE `$tableName` SET $prepareSet WHERE id=$id";
        $updateStatement = $this->dbConnection->prepare($updateQuery);
        $updateStatement->execute();

        if($updateStatement->rowCount())
            return true;
        else
            return false;
    }

    public function updateBysecretkey(string $tableName, array $columns, array $columnsValue, string $key)
    {
        if (!$this->connect())
            throw new Exception;

        $prepareSet = "";
        for($index = 0; $index < count($columns); $index++)
        {
            if($index === 0)
            {
                $prepareSet .= "$columns[$index] = '$columnsValue[$index]'";
            }
            else
            {
                $prepareSet .= ","."$columns[$index] = '$columnsValue[$index]'";   
            }
        }

        $updateQuery = "UPDATE `$tableName` SET $prepareSet WHERE secret_key=$key";
        $updateStatement = $this->dbConnection->prepare($updateQuery);
        $updateStatement->execute();

        if($updateStatement->rowCount())
            return true;
        else
            return false;
    }

    // be carfull ... since the key here may not be primary then it may delete more than one recored
    public function deleteOne(string $tableName, string $primayKey, string $value)
    {
        if (!$this->connect())
            throw new Exception;

        $deleteQuery = "DELETE FROM `$tableName` where $primayKey = '$value'";
        $deleteStatement = $this->dbConnection->prepare($deleteQuery);
        $deleteStatement->execute();

        if($deleteStatement->rowCount() != 0)
            return true;
        else
            return false;   

    }



    public function isExisted(string $tableName, string $primaryKey, string $value)
    {
        if (!$this->connect())
            throw new Exception;

        // check of the this user is already exist
        $selectQuery = "SELECT $primaryKey FROM $tableName where $primaryKey = '{$value}'";
        $selectStatement = $this->dbConnection->prepare($selectQuery);
        $selectStatement->execute();

        if($selectStatement->rowCount() != 0)
            return true;
        else
            return false;
        
    }


    public function join_two_tables(string $table1, string $table2, string $column1, string $column2 , string $select,string $condition="")
    {
        if (!$this->connect())
            throw new Exception;
//        $orders = $db->join_two_tables("order", "user", "user_id", "id");
//        SELECT * FROM `order` INNER JOIN `user` ON `order`.`user_id` = `user`.`id`
//        `order`.* , `user`.name , `user`.profile_picture
        $query = "SELECT $select FROM `$table1` INNER JOIN `$table2` ON `$table1`.`$column1` = `$table2`.`$column2`
        WHERE $condition";
        $statement = $this->dbConnection->prepare($query);
        $statement->execute();

        if($statement->rowCount() != 0)
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        else
            return [];
    }

//    public function join_three_tables(
//        string $table1, string $table2, string $table3, string $column1, string $column2 , string $column3,string $select="*",string $condition=""
//    )
//    {
//        if (!$this->connect())
//            throw new Exception;
//
//        $query = "SELECT $select FROM `$table1`
//              INNER JOIN `$table2` ON `$table1`.`$column1` = `$table2`.`$column2`
//              INNER JOIN `$table3` ON `$table2`.`$column2` = `$table3`.`$column3`
//              WHERE $condition";
//        $statement = $this->dbConnection->prepare($query);
//        $statement->execute();
//
//        if($statement->rowCount() != 0)
//            return $statement->fetchAll(PDO::FETCH_ASSOC);
//        else
//            return [];
//    }
    public function join_four_tables(
        string $table1,
        string $table2,
        string $table3,
        string $table4,
        string $column1,
        string $column2,
        string $column3,
        string $column4,
        string $select = "*",
        string $condition=""
    ){
        if (!$this->connect())
            throw new Exception;

        $query = "SELECT $select FROM `$table1` 
          INNER JOIN `$table2` ON `$table1`.`$column1` = `$table2`.`$column2`
          INNER JOIN `$table3` ON `$table2`.`$column2` = `$table3`.`$column3`
          INNER JOIN `$table4` ON `$table3`.`$column3` = `$table4`.`$column4` WHERE $condition";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute();

        if($statement->rowCount() != 0)
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        else
            return [];
    }

    public function join_two_tables_with_date_range(
        string $table1, string $table2, string $column1, string $column2 ,
        string $start_date, string $end_date,string $select="*",string $condition=""
    ) {
        if (!$this->connect()) {
            throw new Exception;
        }

        $query = "SELECT $select FROM `$table1` INNER JOIN `$table2` ON `$table1`.`$column1` = `$table2`.`$column2` 
              WHERE $condition AND `$table1`.`date` BETWEEN :start_date AND :end_date";
        $statement = $this->dbConnection->prepare($query);
        $statement->bindValue(':start_date', $start_date);
        $statement->bindValue(':end_date', $end_date);
        $statement->execute();

        if ($statement->rowCount() != 0) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
//    public function join_three_tables_with_date_range(
//        string $table1, string $table2, string $table3, string $column1, string $column2, string $column3,
//        string $start_date, string $end_date,string $select="*",string $condition=""
//    ) {
//        if (!$this->connect()) {
//            throw new Exception;
//        }
//
//        $query = "SELECT $select FROM `$table1`
//              INNER JOIN `$table2` ON `$table1`.`$column1` = `$table2`.`$column2`
//              INNER JOIN `$table3` ON `$table2`.`$column2` = `$table3`.`$column3`
//              WHERE $condition AND `$table1`.`date` BETWEEN :start_date AND :end_date";
//        $statement = $this->dbConnection->prepare($query);
//        $statement->bindValue(':start_date', $start_date);
//        $statement->bindValue(':end_date', $end_date);
//        $statement->execute();
//
//        if ($statement->rowCount() != 0) {
//            return $statement->fetchAll(PDO::FETCH_ASSOC);
//        } else {
//            return [];
//        }
//    }
    public function join_three_tables(
        string $table1, string $table2, string $table3,
        string $joinCondition1, string $joinCondition2,
        string $select = "*", string $condition = ""
    ) {
        if (!$this->connect()) {
            throw new Exception("Failed to connect to the database.");
        }

        $query = "SELECT $select FROM `$table1`
              INNER JOIN `$table2` ON $joinCondition1
              INNER JOIN `$table3` ON $joinCondition2
              WHERE $condition";
        $statement = $this->dbConnection->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function join_three_tables_with_date_range(
        string $table1, string $table2, string $table3,
        string $joinCondition1, string $joinCondition2,
        string $start_date, string $end_date,string $select="*",string $condition=""
    ) {
        if (!$this->connect()) {
            throw new Exception;
        }

        $query = "SELECT $select FROM `$table1` 
              INNER JOIN `$table2` ON $joinCondition1
              INNER JOIN `$table3` ON $joinCondition2
              WHERE $condition AND `$table1`.`date` BETWEEN :start_date AND :end_date";
        $statement = $this->dbConnection->prepare($query);
        $statement->bindValue(':start_date', $start_date);
        $statement->bindValue(':end_date', $end_date);
        $statement->execute();

        if ($statement->rowCount() != 0) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
    public function search($table,$keyword,$value){
        if (!$this->connect()) {
            throw new Exception;
        }

        $query = "select * from $table where $keyword like '%$value%'";
        $statement = $this->dbConnection->prepare($query);
        $statement->execute();

        if ($statement->rowCount()!= 0) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

}

?>