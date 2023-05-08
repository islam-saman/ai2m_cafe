<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    $cate_id = $_POST["cateId"];

    try
    {
        $db = new Database(dbUser, dbPass, dbName);
        $is_category_exist = $db->isExisted("category", "id", $cate_id);

        if(!$is_category_exist)
        {
            echo json_encode(array("status"=> 404, "error" => "No Category Found"));
            exit;
        }

        $deleted_Category = $db->deleteOne("category", "id", $cate_id);

        if($deleted_Category)
        {
            echo json_encode("deleted successfully");
        }
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>