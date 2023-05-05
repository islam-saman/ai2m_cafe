<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

include 'database.php';

// send object_of_db and $tablename and $key and $value
function check_admin($db, string $tablename, string $key, string $value)
{
    try {
        if ($db) {
            $is_key_found = $db->isExisted($tablename, $key, $value);
            if ($is_key_found) {
                $Data = $db->fetchOne($tablename, $key, $value);
                if ($Data["is_admin"] == "0") {
                    echo json_encode(["is_admin" => false]);
                } else {
                    echo json_encode(["is_admin" => true]);
                }
            } else {
                return "This Key Not Found";
            }
        } else {
            return "Error in database";
        }
    } catch (Exception $dbConError) {
        $dbConError->getTrace();
    }
}

