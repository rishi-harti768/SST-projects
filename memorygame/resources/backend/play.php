<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $report = array();
    if (isset($_POST['playername'])) {
        $report["playername"] = $_COOKIE["playername"];
    }
    if( isset($_POST["board"]))
    {
        $board = "";
        $imgs = scandir($_SERVER['DOCUMENT_ROOT']."resources/images");
        $imgs = array_diff($imgs, array(".", ".."));
        $imgs = array_merge($imgs, $imgs);
        shuffle($imgs);

        for($i = 0; $i < count($imgs); $i++)
        {
            $board .= /* "<img src='/resources/images/".$imgs[$i].'?v='.rand(1111, 9999)."' class= 'cards ".explode(".", $imgs[$i])[0]."' id='card".($i+1)."'>"; */
            "<div class='cards ".explode('.', $imgs[$i])[0]."'>
            <div class='cover ".explode('.', $imgs[$i])[0]."' id='cover".$i."'>
            </div>
            <img src='/resources/images/".$imgs[$i].'?v='.rand(1111, 9999)."' class= 'cards ".explode('.', $imgs[$i])[0]."' id='card".($i+1)."'>
          </div>";
        }
        $report["board"] = $board;
    }
    echo json_encode($report, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
