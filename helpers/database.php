<?php 


class Database
{
    private string $dbHost;
    private int $dbPort;
    private string $dbUser;
    private string $dbPass;
    private string $dbName;
    private $dbConnection;

    function __construct(string $dbHost, int $dbPort, string $dbUser, string $dbPass, string $dbName)
    {
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
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
            echo $dbConError->getMessage();
        }
    }


    public function fetchALl($tableName)
    {
        if (!$this->connect())
            throw new Exception;
        

        $selectQuery = "SELECT * FROM $tableName";
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

        $selectQuery = "SELECT * FROM $tableName where $primaryKey = '{$value}'";
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

        $insrtQuery = "INSERT INTO $tableName ($rowColumns) values ($rowValues)";
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
        echo $prepareSet;


        $updateQuery = "UPDATE $tableName SET $prepareSet WHERE id=$id";
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

        $deleteQuery = "DELETE FROM $tableName where $primayKey = '$value'";
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


}

?>