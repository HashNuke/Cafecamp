<?php

    include("../protect.php");
    
    if($x_login=1)
    {
        list($user_email, $user_id, $profile_created) =  split("::", $_SESSION['user'], 3);
    }
    
    include("../ccconfig.php");
    include_once("../dbal.php");

    if($profile_created=="0")
    {
        header("location:index.php?action=createp");
    }

?>