<?php
    $response = "";
    if(isset($_POST) && (!empty($_POST['serverKey']))){
        $target = [$_POST['token']];

        $notificationBody['data'] = [
            'type' => 1,
            'url' => "https://trinitytuts.com/wp-content/uploads/2018/07/macaw.png",
            'title' => $_POST['title'],
            "msg" => $_POST['description']
        ];
        
        $response = sendMessage($notificationBody, $target, $_POST['serverKey']);
    }
    

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Firebase push notification android example</title>
  </head>
  <body>
    <div class="container">
        <h1 class="text-center">Firebase push notification android example</h1>
        <p></p>
        <div class="row mt-5">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group">
                        <label for="token">Token</label>
                        <input type="text" class="form-control" id="token" name="token">
                    </div>
                    <div class="form-group">
                        <label for="serverKey">Server Key</label>
                        <input type="text" class="form-control" id="serverKey" name="serverKey">
                    </div>
                
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div>
            <pre>
                <?php
                    print_r($response);
                ?>
            </pre>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

<?php

function sendMessage($data, $target, $serverKey){
    //FCM api URL
    $rsp = [];
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = $serverKey;
    $fields = array();
    $fields['data'] = $data;
    if(is_array($target)){
            $fields['registration_ids'] = $target;
        }else{
            $fields['to'] = $target;
    }
    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$server_key
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        //die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    //print_r($result);
    return $result;
}