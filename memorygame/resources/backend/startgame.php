<?php
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_POST["playername"]))
        {
            setcookie("playername", $_POST["playername"], time() + 3600, "/");
            header("Location: /web/play/");
        }
        else{
            header("Location: /");
        }
    }
    else{
        header("Location: /");
    }
?>