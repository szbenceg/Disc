<?php

    session_start();
    
    include 'links.php';

    $data = null;

    if($_POST["requestType"] == "registration"){
        $query = "INSERT INTO users (`user_name`, `password` , `email_address`) VALUES ('".$_POST['userName']."','".$_POST['password']."' , '".$_POST['emailAddress']."')";
        if (mysqli_query($dbConn, $query)){
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        
        $_SESSION['id'] = mysqli_insert_id($dbConn);
        
        //setcookie('userId', $id, time() + 86400 * 365, "/");
    }

    if($_POST["requestType"] == "logIn"){
        $data["message"] = null;
        $query = "SELECT * FROM users WHERE `email_address`='".$_POST['emailAddress']."' AND `password`='".$_POST['password']."'";
        if($result = mysqli_query($dbConn, $query)){
            $row = mysqli_fetch_array($result);
            if($row["id"] != null){
                $_SESSION["userId"] = $row["id"];
                $data["success"] = true;
            }else{
                $data["message"] = "Helytelen email cím vagy jelszó!";
            }
        }
    }

    if($_POST["requestType"] == "getDiscs"){

        class DiscData{


            public $discId;
            public $album;

            /*public $userId;
            public $artist;
            public $album;
            public $released;
            public $country;
            public $discCondition;
            public $description;*/

            /*function DiscData($discId, $userId, $artist, $album, $released, $country, $discCondition, $description){
                $this->discId = $discId;
                $this->userId = $userId;
                $this->artist = $artist;
                $this->album = $album;
                $this->released = $released;
                $this->country = $country;
                $this->discCondition = $discCondition;
                $this->description = $description;
            }*/
            function DiscData($discId, $album){
                $this->discId = $discId;               
                $this->album = $album;
            }
        }

        $data["pop"] = array();
        $data["rock"] = array();
        $data["hipHop"] = array();
        $data["electronical"] = array();
        $data["classical"] = array();
        $data["country"] = array();
        $data["owner"] = array();

        $query = "SELECT * FROM discs";
        $result = mysqli_query($dbConn, $query);

        while($row = mysqli_fetch_array($result)){
            array_push($data[$row["genre"]], new DiscData($row["id"], $row["album"])); 
            array_push($data["owner"], $row["user_id"]); 
        }

    }


    if($_POST["requestType"] == "getSpecDisc"){

        $query = "SELECT * FROM discs, users WHERE discs.id='".$_POST['discId']."' AND discs.user_id=users.id";
        $result = mysqli_query($dbConn, $query);
        $data = mysqli_fetch_array($result);

        if(array_key_exists("userId", $_SESSION)){
            $data["senderId"] = $_SESSION["userId"];
        }else{
            $data["senderId"] = null;
        }

    }

    if($_POST["requestType"] == "sendMessage"){

        if($_POST["message"] == ""){

            $data["success"] = false;
            $data["errorMessage"] = "Az üzenet nem lehet üres!";

        }else{

            $query = "INSERT INTO `message`(sender_id, receiver_id, `message`, `date`) VALUES ('".$_POST['senderId']."','".$_POST['ownerId']."','".$_POST['message']."','".date('Y-m-d H:i:s')."')";
            if(mysqli_query($dbConn, $query)){
                $data["success"] = true;
            }else{
                $data["success"] = false;
                $data["errorMessage"] = "Sikertelen üzenetküldés, kérjük próbálja meg később!";

            }
        }
    }

    if($_POST["requestType"] == "getReceivedMessagesNumber"){
        $query = "SELECT message_number AS messagesNumber FROM `newmessages` WHERE receiver_id='".$_SESSION['userId']."'";
        $result = mysqli_query($dbConn, $query);
        $row = mysqli_fetch_array($result);

        $data["messagesNumber"] = $row["messagesNumber"];
    }

    if($_POST["requestType"] == "getMessages"){

        $data["messages"] = null;

        $query = "SELECT * FROM `message` WHERE (sender_id='".$_POST['senderId']."' OR sender_id='".$_SESSION['userId']."') AND (receiver_id='".$_POST['senderId']."' OR receiver_id='".$_SESSION['userId']."') ORDER BY date ASC";
        $result = mysqli_query($dbConn, $query);
        
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $data["messages"][$i] = $row;
            $i++;
        }

        $query = "SELECT `user_name` FROM users WHERE `id`='".$_POST['senderId']."'";
        $result = mysqli_query($dbConn, $query);
        $row = mysqli_fetch_array($result);
        $data["userName"] = $row["user_name"];
    }

    if($_POST["requestType"] == "sendChatMessage"){

        $query = "INSERT INTO `message` (sender_id, receiver_id, `message`, `date`) VALUES ('".$_SESSION['userId']."','".$_POST['receiverId']."','".$_POST['textMessage']."','".date('Y-m-d H:i:s')."')";
        if(mysqli_query($dbConn, $query)){
            $query = "SELECT id FROM newmessages WHERE receiver_id='".$_POST['receiverId']."' AND sender_id='".$_SESSION['userId']."'";
            $result = mysqli_query($dbConn, $query);
            $size = mysqli_num_rows($result);
            $data["size"] = $size;
            if(mysqli_num_rows($result) == 0){
                $query = "INSERT INTO `newmessages` (receiver_id, sender_id) VALUES ('".$_POST['receiverId']."','".$_SESSION['userId']."')";
                mysqli_query($dbConn, $query);
            }else{
                $query = "UPDATE `newmessages` SET message_number=message_number+1 WHERE receiver_id='".$_POST['receiverId']."' AND sender_id='".$_SESSION['userId']."'";
                mysqli_query($dbConn, $query);
            }
        }

        /*$query = "INSERT INTO `newmessages` (sender_id, receiver_id, `message_number`) VALUES ('".$_SESSION['userId']."','".$_POST['receiverId']."','".$_POST['textMessage']."','".date('Y-m-d H:i:s')."')";
        mysqli_query($dbConn, $query);*/
    }

   if($_POST["requestType"] == "updateMessages"){

        $data["messages"] = null;

        $query = "SELECT * FROM `message` WHERE id>'".$_POST['lastSelectedId']."' AND (sender_id='".$_POST['senderId']."' OR sender_id='".$_SESSION['userId']."') AND (receiver_id='".$_POST['senderId']."' OR receiver_id='".$_SESSION['userId']."')  ORDER BY date ASC";
        $result = mysqli_query($dbConn, $query);
        
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $data["messages"][$i] = $row;
            $i++;
        }
    }
    
    if($_POST["requestType"] == "getRequestMessages"){
        $data["message"] = null;

        $query = "SELECT users.user_name AS userName, users.id AS senderId FROM `message`, users WHERE users.id=message.sender_id AND (receiver_id='".$_SESSION['userId']."') GROUP BY message.sender_id";
        $result = mysqli_query($dbConn, $query);
        $i=0;
        while($row = mysqli_fetch_array($result)){
            $data["message"][$i] = $row;
            $i++;
        }

        /*$query = "SELECT COUNT(sender_id) AS idNumber, sender_id, users.user_name AS userName, users.id AS senderId FROM `message`, `users` WHERE users.id=receiver_id AND sender_id='".$_SESSION['userId']."' GROUP BY sender_id HAVING idNumber = 1";
        $result = mysqli_query($dbConn, $query);
        while($row = mysqli_fetch_array($result)){
            $data["message"][$i] = $row;
            $i++;
        }*/

        for($j=0; $j<$i; $j++){
            $query = "SELECT `message` FROM `message` WHERE (receiver_id='".$_SESSION['userId']."'AND sender_id='".$data['message'][$j]['senderId']."') OR (receiver_id='".$data['message'][$j]['senderId']."'AND sender_id='".$_SESSION['userId']."') ORDER BY `date` DESC LIMIT 1";
            $result = mysqli_query($dbConn, $query);
            $row = mysqli_fetch_array($result);
            $data["lastMessage"][$j] = $row["message"];
        }

    }

    if($_POST["requestType"] == "receivedMessage"){
        $query = "UPDATE newmessages SET message_number='0' WHERE receiver_id='".$_SESSION['userId']."' AND sender_id='".$_POST['senderId']."'";
        if(mysqli_query($dbConn, $query)){
            $data["success"] = true;
        }else{
            $data["success"] = false;
        }
    }

    if($_POST["requestType"] == "getNumOfNewMessages"){
        $query = "SELECT message_number, sender_id FROM newmessages WHERE receiver_id='".$_SESSION['userId']."'";
        $result = mysqli_query($dbConn, $query);
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $data["senderId"][$i] = $row["sender_id"];
            $data["messageNumber"][$i] = $row["message_number"];
            $i++;
        }
    }

    if($_POST["requestType"] == "uploadVinyl"){

        if($_POST["artist"] == "" || $_POST["albumName"] == "" || $_POST["genre"] == "" || $_POST["released"] == "" || $_POST["country"] == "" || $_POST["condition"] == ""){

            $data["success"] = false;
            $data["errorMessage"] = "Töltse ki a kötelező mezőket!";

        }else{

            if(array_key_exists("userId", $_SESSION)){
                $user_id = $_SESSION["userId"];
            }else{
                $user_id = null;
            }

            $query = "INSERT INTO `discs`(`user_id`, genre, artist, album, released, country, disc_condition, `description`) VALUES ('".$user_id."','".$_POST['genre']."','".$_POST['artist']."','".$_POST['albumName']."','".$_POST['released']."','".$_POST['country']."','".$_POST['condition']."','".$_POST['description']."')";
            if(mysqli_query($dbConn, $query)){

                $data["success"] = true;

                $imageId = mysqli_insert_id($dbConn);
                $explodedFileName = explode('.', $_FILES['image']['name']);
                $fileType = end($explodedFileName);
                $newFileName = $imageId. "." . $fileType;
                $uploadLocation = "vinyls/". $newFileName;

                if($fileType == "jpg" OR $fileType == "JPG"){
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadLocation)){
                        $data["success"] = "Sikeres feltöltés!";
                    }else{
                        $data["error"] = "Sikertelen feltöltés!";
                        $query = "DELETE FROM `discs` WHERE id='".$imageId."'";
                        mysqli_query($dbConn, $query);
                    }
                }else{
                    $data["warning"] = "A file típúsa csak jpg lehet!";
                    $query = "DELETE FROM `discs` WHERE id='".$imageId."'";
                    mysqli_query($dbConn, $query);
                }

            }else{
                $data["success"] = false;
                $data["errorMessage"] = "Sikertelen feltöltés, kérjük próbálja meg később!";
            }
        }
    }


    if($_POST["requestType"] == "getOwnDiscs"){


        $query = "SELECT * FROM discs WHERE `user_id`='".$_SESSION['userId']."'";
        $result = mysqli_query($dbConn, $query);
        $i = 0;
        while($row = mysqli_fetch_array($result)){

            $data["discId"][$i] = $row["id"];
            $data["album"][$i] = $row["album"];
            $i++;
        }
    }


    echo json_encode($data);
?>
