<?php 

    // include the env file
    include "../../../env.php";
    include "../../../helpers/database.php";

    $cate_id = $_POST["cateId"];
    $cate_name = $_POST["cateName"];


    try
    {
        $db = new Database(dbUser, dbPass, dbName);
        $is_category_exist = $db->isExisted("category", "id", $cate_id);

        if(!$is_category_exist)
        {
            echo json_encode(array("status"=> 404, "error" => "No Category Found"));
            exit;
        }

        $update_category = $db->updateById("category", ["name"], [$cate_name], $cate_id);

        if($update_category)
        {
            echo json_encode("updated successfully");
        }
    }
    catch(Exception $dbConError)
    {
        $dbConError->getMessage();
    }


?>