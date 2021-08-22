<?php
require '../db_credentials.php';
require '../utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$return_data="";

if(isset($_POST['material_id'])){
    $material_id = sanitizeInput($_POST['material_id']);

    if($material_id == "all"){
        $query = "select r.quantity,r.date,o.name,o.department,m.material_id,m.material_type,m.exam_id from returned r, exam_official o, exam_material m where r.official_id = o.official_id and r.material_id = m.material_id";

    } else {
        $query = "select r.quantity,r.date,o.name,o.department,m.material_id,m.material_type,m.exam_id from returned r, exam_official o, exam_material m where r.material_id = '$material_id' and r.official_id = o.official_id and r.material_id = m.material_id";
        
    }
    $res = $conn->query($query);

    while($row = $res->fetch_assoc()){
        $return_data .= "<tr>";
        $return_data .= "<td>" . $row['exam_id'] . " " .  $row['material_type'] . "</td>";
        $return_data .= "<td>" . $row['quantity'] . "</td>";
        $return_data .= "<td>" . $row['name'] . " (" . $row['department'] . ")" . "</td>";
        $return_data .= "<td>" . $row['date'] . "</td>";
        $return_data .= "</tr>";
    }
}
echo $return_data;

?>