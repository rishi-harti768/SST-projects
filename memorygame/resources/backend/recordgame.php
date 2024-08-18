<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if(isset($_POST["time"]))
    {
        $openfile = fopen($_SERVER['DOCUMENT_ROOT']."/resources/data/record.json", "r");
        $gamerecord = json_decode(fread($openfile, filesize($_SERVER['DOCUMENT_ROOT']."/resources/data/record.json")), true);
        fclose($openfile);
        if(isset($_COOKIE["playername"]) && $_COOKIE["playername"]!="")
        {
            $newrecord = array();
            $newrecord["gameID"]= "#".count($gamerecord) + 1;
            $newrecord["playername"] = $_COOKIE["playername"];
            $newrecord["time"] = $_POST["time"];
            $gamerecord[] = $newrecord;
            $write =json_encode($gamerecord, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $openfile = fopen($_SERVER['DOCUMENT_ROOT']."/resources/data/record.json", "w");
            fwrite($openfile, $write);
            fclose($openfile);
            echo json_encode($newrecord);
        }
    }
}
?>