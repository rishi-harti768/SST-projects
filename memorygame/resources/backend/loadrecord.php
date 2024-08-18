<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST["gettable"]))
    {
        $report= "<tr>
                    <th>Game ID</th>
                    <th>Name</th>
                    <th>Time</th>
                </tr>";
        $openfile = fopen($_SERVER['DOCUMENT_ROOT']."/resources/data/record.json", "r");
        $gamerecord = json_decode(fread($openfile, filesize($_SERVER['DOCUMENT_ROOT']."/resources/data/record.json")), true);
        fclose($openfile);
        for($i = 0; $i < count($gamerecord); $i++)
        {
            $report .="<tr>
                            <td>".$gamerecord[$i]['gameID']."</td>
                            <td>".$gamerecord[$i]['playername']."</td>
                            <td>".$gamerecord[$i]['time']."</td>
                        </tr>";
        }
        echo $report;
    }
}
?>