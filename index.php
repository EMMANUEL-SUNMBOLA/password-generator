<?php
$err = [];
if (($_SERVER["REQUEST_METHOD"]) == "POST" && (isset($_POST["sub"]))) {
    $lenth = strip_tags($_POST['len']);
    $pass = "";
    $webname = strip_tags($_POST["url"]);
    for ($i = 0; $i < $lenth; $i++) {
        $pass .= chr(33 + rand(0, 89));
    }
    
    if (isset($_POST["yes"])) {
        $file = fopen("passwords.txt", "a+");
        $user = $_POST['user'];
        if (empty($_POST['user'])) {
            $user = 'nil';
        }
        // 1
        // $message = $webname . "|" . $pass . "\n";
        // 2
        // line-break should come before the data to avoid bugs while reading the file 
        // both methods work but ...
        $message = "\n" . $webname . "|" . $user . "|" . $pass;
        fwrite($file, $message);
        $err[] = "password saved";
        fclose($file);
    }
    // header("location:$webname");
} elseif ((isset($_POST["sub"])) && $_SERVER["REQUEST_METHOD"] !== "POST") {
    $err[] = "something wen't wrong";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="dist/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PASSWORD GENERATOR</title>
</head>

<body>
    <div class="errs">
        <h1>
            <?php if (isset($err)) {
                foreach ($err as $cellary) {
                    echo $cellary;
                }
            } ?>
        </h1>
    </div>
    <div class="herd">
        <h1>password generator</h1>
    </div>
    <div class="forms">
        <form method="post">
            <label for="url">website url</label>
            <input type="text" name="url" placeholder="passwordgenerator.com"
                value="<?php if (isset($_POST['sub'])) {
                    $webname;
                } ?>" title="website name"><br>
            <label for="user">username</label>
            <input type="text" name="user" title="username/gmail :leave empty if you're not sure"
                placeholder="donjo@gmail.com" value="<?php if (isset($_POST['sub'])) {
                    $user;
                } ?>"><br>
            <label for="len">password length</label>
            <input type="text" name="len" placeholder="0 - ~ try us"
                value="<?php if (isset($_POST['sub'])) {
                    $lenth;
                } ?>"><br>
            <p>
                do you want to save your password ?
                <input type="checkbox" name="yes" id="" value="yes">yes
            </p>
            <button name="sub">submit</button>
            <!-- <button name="go" class="copy" onclick="copy()">GO</button> -->
        </form>
        <div class="pass">
            <input type="text" name="pass" value="<?php if (isset($pass)) {
                echo $pass;
            } ?>" id="pass">
            <button onclick="copy()" class="copy">copy</button>
        </div>
    </div>
    <div class="view">
        <h1>view saved passwords</h1>
        <table border="1">
            <tr>
                <th>website name</th>
                <th>username</th>
                <th>password</th>
            </tr>

            <?php
            $file = fopen("passwords.txt", "r");
            while (!feof($file)) {
                $lin = fgets($file);
                if ($lin == null) {
                    $lin = 'end|of|file';
                }
                $line = explode("|", $lin);
                echo '<tr><td>' . $line[0] . '</td>';
                echo '<td>' . $line[1] . '</td>';
                echo '<td>' . $line[2] . '</td></tr>';
            }
            fclose($file);
            ?>

        </table>
    </div>
    <footer>
        <p>like this ? check my <a target="_blank" href="https://github.com/EMMANUEL-SUNMBOLA">GITHUB</a> for more
            awesome projects , if no tell me how to improve @<a target="_blank"
                href="mailto:adedayoemmanuel729@gmail.com">my mail</a></p>
    </footer>
    <script>
        function copy() {
            var copyText = document.getElementById("pass");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value)
            alert("TEXT COPIED:" + copyText.value);
        }
    </script>
</body>

</html>