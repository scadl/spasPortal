
$(document).ready(function () {

    // --------------------------------------
    // Async data loading
     function asyncSend(tUri, sObj){
         var res = -1;
         $.ajax({
             method: "GET",
             url: tUri,
             data: {},
             dataType: "html",
         }).done(function (data) {
             sObj.innerText = data;
             //console.log(data);
         }).fail(function (jqXHR, textStatus) {
            console.error(textStatus);
         });
         return res;
     }

     // --------------------------------------
     // My Player logic
    function btnIconSwitch(obj, dir) {
        if (dir) {
            obj.classList.remove('fa-play');
            obj.classList.add('fa-pause');
        } else {
            obj.classList.remove('fa-pause');
            obj.classList.add('fa-play');
        }
    }
    // Simple player dynamics
    var players = document.getElementsByClassName('play_btn');
    for (var i = 0; i < players.length; i++) {
        players[i].onclick = function () {
            // Finding UI elements
            var audioID = this.getAttribute('audio_id');
            var audio = document.getElementById('audio_object_' + audioID);
            var btn = document.getElementById('play_ctrl_' + audioID);
            var playBadge = document.getElementById('play_num_' + audioID);
            // Handling Events
            audio.onended = function(){btnIconSwitch(btn, false);}
            if (audio.paused) {
                audio.play();
                btnIconSwitch(btn, true);
                // Play event
                var myRoute = this.getAttribute('route');
                var asRes = asyncSend(myRoute, playBadge);
            } else {
                audio.pause();
                btnIconSwitch(btn, false);
            }
        }
    }
    // Downloads dynamics
    var downs = document.getElementsByClassName('dw_btn');
    for (var i = 0; i < downs.length; i++) {
        downs[i].onclick = function () {
            var audioID = this.getAttribute('audio_id');
            var dwBadge = document.getElementById('dw_num_' + audioID)
            var myRoute = this.getAttribute('route');
            asyncSend(myRoute, dwBadge); // download event
        }
    }
});
