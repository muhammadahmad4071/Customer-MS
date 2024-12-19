<?php

session_start();
$dbObj = new DbClass();

$login = $_SESSION['login'];
$action = $_POST['action'];

if ($action == "ADD") {
    $Name = $_POST['name'];
    $ContactNo = $_POST['contactNo'];
    $Address = $_POST['address'];


    $query = "INSERT INTO customerrecords (ID,NAME,ADDRESS,CONTACT_NO,OPERATOR,DATETIME,STATUS,UPDATED_AT,UPDATED_BY)
VALUES (customerrecords_id_seq.nextval,'$Name','$Address','$ContactNo','$login',SYSDATE,'active',SYSDATE,'$login')";

    $customerDetail = $dbObj->execInsertUpdate($query);

    if ($customerDetail) {
        echo json_encode($customerDetail);
    } else {
        echo "Error inserting data";
    }
} else if ($action == "SHOW") {
    $query = "SELECT ID,NAME,ADDRESS,CONTACT_NO,OPERATOR,TO_CHAR(DATETIME, 'DD-MON-YYYY HH24:MI:SS') AS DATETIME,STATUS,TO_CHAR(UPDATED_AT, 'DD-MON-YYYY HH24:MI:SS') AS UPDATED_AT,UPDATED_BY from esfizza.customerrecords WHERE STATUS ='active' ORDER BY DATETIME DESC";

    $result = $dbObj->execSelect($query);
    $dataArray = array();

    for ($i = 0; $i < count($result); $i++) {
        $customerID = $result[$i]['ID'];
        $rowData = array(
            $i + 1,
            $result[$i]['NAME'],
            $result[$i]['ADDRESS'],
            $result[$i]['CONTACT_NO'],
            $result[$i]['OPERATOR'],
            $result[$i]['DATETIME'],
            $result[$i]['STATUS'],
            $result[$i]['UPDATED_AT'],
            $result[$i]['UPDATED_BY'],
            "     <div class='d-flex'>
            <a class='btn btn-primary' onclick = 'editCustomer($customerID)' >Edit</a>
            <a class='btn btn-danger' onclick = 'deleteCustomer($customerID)'>Delete</a>
            </div>     
            ",
        );

        $dataArray[] = $rowData;
    }

    $resArray = array('data' => $dataArray);
    echo json_encode($resArray);
} else if ($action == "DEL") {
    $customerID = $_POST['customerID'];
    $query = "UPDATE customerrecords SET STATUS = 'inactive' WHERE ID='$customerID'";

    $customerDetail = $dbObj->execInsertUpdate($query);
    echo json_encode($customerDetail);
} else if ($action == "EDIT") {
    $customerID = $_POST['customerID'];

    $query = "SELECT NAME,ADDRESS,CONTACT_NO FROM customerrecords where ID='$customerID'";
    $result = $dbObj->execSelect($query);

    if ($result && count($result) > 0) {
        echo json_encode($result[0]);
    } else {
        echo json_encode(['error' => 'Customer details not found']);
    }
} else if ($action == "UPDATE") {

    $Name = $_POST['name'];
    $ContactNo = $_POST['contactNo'];
    $Address = $_POST['address'];
    $customerID = $_POST['customer_id'];
    $query = "UPDATE customerrecords 
    SET NAME= '$Name',ADDRESS='$Address',CONTACT_NO='$ContactNo'
    WHERE ID='$customerID'";


    $customerDetail = $dbObj->execInsertUpdate($query);
    echo json_encode($customerDetail);
}

?>