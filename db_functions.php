<?php
include_once 'db_connection.php';

class dbCrudFunctions
{
    private $dbConnection;

    // Constructor
    function __construct() {
        $db_conn = new DbConnection();
        $this->dbConnection = $db_conn->getDbConnection();
    }

    function getAllProducts()
    {
        //using mysqli query method to run the query
        $result = mysqli_query($this->dbConnection, "select * from products") or die(mysqli_error());

        //Initialize the storage array
        $results = array();
        //loop through the results
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ //MYSQLI_NUM returns the array index which is number whereas MYSQLI_ASSOC returns the associative array index which is column_name of database.
            array_push($results, $row);
        }
        return $results;

    }

    function getProductById($id)
    {
        $result = mysqli_query($this->dbConnection, "select * from products where product_id = $id") or die(mysqli_error());

        return $result;
    }

    function registerUser($fullname, $address, $email, $contact, $password){
        $result = mysqli_query($this->dbConnection, "INSERT INTO users(fullname, address, contact_no, email, password)
                                values('".$fullname."','".$address."','".$contact."','".$email."','".$password."')") or die(mysqli_error());

        return $result;
    }

    function addProduct($product_name, $price, $image, $description){
        $result = mysqli_query($this->dbConnection, "INSERT INTO products(product_name, description, price, image_src)
                                values('".$product_name."','".$description."','".$price."','".$image."')") or die(mysqli_error());

        return $result;
    }

    function updateProduct($Id, $product_name, $price, $image, $description){
        $result = mysqli_query($this->dbConnection, "UPDATE products SET product_name = '".$product_name."', price = '".$price."', image_src = '".$image."', description = '".$description."' WHERE product_id = '".$Id."'" ) or die(mysqli_error($this->dbConnection));

        return $result;
    }

    function deleteProduct($product_id){
        $result = mysqli_query($this->dbConnection, "DELETE from products where product_id = '$product_id'");

        return $result;
    }
}