<?php

require_once 'db.php';


$db = new Database();

if(isset($_POST['action']) && $_POST['action'] == "view"){
    $output = '';
    $data = $db->read();
    
    if($db->totalRowCount() > 0 ){
        $output .= '<table class="table table-striped table-sm table-bordered">
                    <thead>
                    <tr class="text-center">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>E-Mail</th>
                    <th>Car</th>
                    <th>Action</th>
                     </tr>
                    </thead>
                     <tbody>';

            foreach($data as $row){
                $output .= '<tr class="text-center text-secondary">
                <td>'.$row['id'].'</td>
                <td>'.$row['first_name'].'</td>
                <td>'.$row['last_name'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['car'].'</td>
                <td>
                <a href="#" title="Details" class="text-success"><i class="fas fa-info-circle fa-lg infoBtn"
                id="'.$row['id'].'"></i></a>&nbsp;&nbsp;

                <a href="#" title="Edit" class="text-primary"><i class="fas fa-edit fa-lg editBtn" data-toggle="modal" 
                data-target="#editModal" id="'.$row['id'].'"></i></a>&nbsp;&nbsp;

                <a href="#" title="Delete" class="text-danger delBtn" id="'.$row['id'].'"><i class="fas fa-trash fa-lg"></i></a>
                </td></tr>
                ';
            }

        $output .= '</tbody></table>';
        echo $output;

    }else{
        echo '<h3 class = "text-center text-secondary mt-5">Database is empty!</h3>';
    }

}

if(isset($_POST['action']) && $_POST['action'] == "insert"){

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $car = $_POST['car'];

    $db->insert($fname,$lname,$email,$car);

}

if(isset($_POST['edit_id'])){

    $id = $_POST['edit_id'];

    $row = $db->getUserById($id);

    echo json_encode($row);

}


if(isset($_POST['action']) && $_POST['action'] == "update"){

    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $car = $_POST['car'];

    $db->update($id,$fname,$lname,$email,$car);

}


if(isset($_POST['del_id'])){

   // console.log("aaaaaaaaaaaaa");
    $id = $_POST['del_id'];

    $db->delete($id);

}


?>