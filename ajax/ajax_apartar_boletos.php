<?php session_start();
// echo 'Session: ' . $_SESSION['id'] .'<br>';
if($_SESSION['id'] == session_id()){
    // $data = json_decode($_POST['array']);
    // var_dump($data);
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);
    var_dump($input);
}
else{
    echo "error";
}


?>