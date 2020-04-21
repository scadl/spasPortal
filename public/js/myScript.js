
$(document).ready(function () {

    // --------------------------------------
    // Async data loading
     function asyncSend(tUri, sObj, isTxtResp, sData= {}){
         var res = -1;
         $.ajax({
             method: "GET",
             url: tUri,
             data: sData,
         }).done(function (data) {
             try {
                 if (isTxtResp) {
                     sObj.innerText = data;
                 } else {
                     //console.log(data);
                     sObj.removeClass('disabled');
                     window.location = panelRoute;
                 }
             }catch (e) {
                 console.log(data);
             }
             //console.log(data);
         }).fail(function (jqXHR, textStatus) {
            console.error(textStatus);
         });
         return res;
     }

     // Password GenSimple
    function randDiapInt(min, max){
         return Math.round(min + Math.random() * (max - min));
    }
    $('#passgen').click(function () {
        var pass = "";
        for (var i=0; i<8; i++){
            pass += String.fromCharCode(randDiapInt(48,122) )
        }
        $('#password').attr("type","text");
        $('#password-confirm').attr("type","text");
        $('#password').val(pass);
        $('#flbl').text(pass);
        $('#password-confirm').val(pass);
    });

     // Loop palyback - WIP
     $('.repeat_btn').click(function () {
        $(this).toggleClass('active');
        var audio = $(this).attr('audio_id');
        $('#audio_object_'+audio).attr("loop", !$('#audio_object_'+audio).attr("loop"));
     });

     // "Rename track > save" button.
     $('.btn_rename').click(function () {
         var data = $(this).parent().prev().val();
         var myRoute = this.getAttribute('route');
         asyncSend(myRoute, null, true, {'newname':data});
     })

     // "Scan files" button
    $('#fScan').click(function () {
        $(this).addClass('disabled');
        asyncSend(scanRoute, $(this), false);
    });

     // --------------------------------------
     // My Player logic
    var playTimer = null;
    function btnIconSwitch(obj, dir) {
        if (dir) {
            obj.classList.remove('fa-play');
            obj.classList.add('fa-pause');
        } else {
            obj.classList.remove('fa-pause');
            obj.classList.add('fa-play');
        }
    }
    function secToHMS(sec) {
        var date = new Date(0);
        date.setSeconds(Math.round(sec));
        return date.toISOString().substr(11,8);
    }
    function playTimePos(audioID) {
        $("#curTime_"+audioID).text(
            secToHMS(
                document.getElementById('audio_object_' + audioID).currentTime
            )
        );
    }
    // Simple player dynamics
    var players = document.getElementsByClassName('play_btn');
    for (var i = 0; i < players.length; i++) {
        players[i].onclick = function () {
            // Finding UI elements
            var audioID = this.parentNode.getAttribute('audio_id');
            var audio = document.getElementById('audio_object_' + audioID);
            var btn = document.getElementById('play_ctrl_' + audioID);
            var playBadge = document.getElementById('play_num_' + audioID);
            // Handling Events
            audio.onended = function(){
                btnIconSwitch(btn, false);
            }
            if (audio.paused) {
                audio.play();
                playTimer = setInterval(function(){playTimePos(audioID)}, 500);
                btnIconSwitch(btn, true);
                // Play event
                var myRoute = this.getAttribute('route');
                var asRes = asyncSend(myRoute, playBadge, true);
            } else {
                audio.pause();
                clearInterval(playTimer);
                btnIconSwitch(btn, false);
            }
        }
    }
    // Set step time
    $('.dropdown-item').click(function () {
        var audioID = $(this).parent().attr("audio_id");
        $(this).siblings().each(function () {
            $(this).removeClass("active");
        });
        $(this).addClass("active");
        $("#audio_object_"+audioID).attr("step", $(this).attr("vsec"))
    });
    // Seek buttons handlers
    $(".s_bkw,.s_fwd").click(function () {
        var audioID = $(this).parent().attr("audio_id");
        var audioObj = document.getElementById("audio_object_" + audioID);
        if(Boolean($(this).attr("direction"))) {
            audioObj.currentTime += Number(audioObj.getAttribute("step"));
        } else {
            audioObj.currentTime -= Number(audioObj.getAttribute("step"));
        }
    })
    // Prescan Durations
    var audios = document.getElementsByClassName('audio');
    for (var i = 0; i < audios.length; i++) {
        var audioID = audios[i].getAttribute('audio_id');
        var audio = document.getElementById('audio_object_' + audioID);
        document.getElementById("trkTime_"+ audioID).innerText = secToHMS(audio.duration);
    }
    // Downloads dynamics
    var downs = document.getElementsByClassName('dw_btn');
    for (var i = 0; i < downs.length; i++) {
        downs[i].onclick = function () {
            var audioID = this.getAttribute('audio_id');
            var dwBadge = document.getElementById('dw_num_' + audioID)
            var myRoute = this.getAttribute('route');
            asyncSend(myRoute, dwBadge, true); // download event
        }
    }

});
