<?php
function getJson($file) {
    //read file into string
    $str = file_get_contents($file);

    //convert json string to php array
    $array = json_decode($str);

    return $array;
}

function putJson($file, $array) {
    //convert php array to json string
    $str = json_encode($array);

    //write string into file
    $file_put_contents($file, $str);
}
?>
