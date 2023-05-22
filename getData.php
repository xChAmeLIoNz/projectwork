<?php

$data = array(
    'response' => ''
);

if (isset($_POST['data'])) {

    $string = $_POST['data'];

    $data['response'] = "questa cosa funziona!";

}

echo json_encode($data);