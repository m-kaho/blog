<?php 
function readComment() {
    $comments = array();

    $filename = "memo.txt";
    $file = file($filename);
    foreach($file as $row) {
        $items = explode("%%", $row);
        $comments[] = array(
            "datetime" => $items[0],
            "text" => $items[1],
        );
    }
    return $comments;
}