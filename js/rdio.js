var rdioToken = null;
var playback_token = "GA1R4x3d_____zU4dHVmdmoyamQ0OThicjhnd201eXh6dnJoeW1lbGluZS5uZXR4QdrqvBku68PpQAYHzGkN";
var domain = "rhymeline.net";
var play_key = "p4583711";//"a1997246";


// a global variable that will hold a reference to the api swf once it has loaded
var apiswf = null;

$(document).ready(function() {
    // on page load use SWFObject to load the API swf into div#apiswf
    var flashvars = {
        'playbackToken': playback_token, // from token.js
        'domain': domain,                // from token.js
        'listener': 'callback_object'    // the global name of the object that will receive callbacks from the SWF
    };
    var params = {
        'allowScriptAccess': 'always'
    };
    var attributes = {};
    var infoLeft = 0, infoWidth = $("#info-container").width();

    swfobject.embedSWF('http://www.rdio.com/api/swf/', // the location of the Rdio Playback API SWF
        'apiswf', // the ID of the element that will be replaced with the SWF
        1, 1, '9.0.0', 'expressInstall.swf', flashvars, params, attributes);

    // set up the controls
    $('#play').click(function() {
        apiswf.rdio_play(play_key);
        apiswf.rdio_setRepeat(0);
        $(this).hide();
        $('#pause').show();
        $("#info-container .info").show();
        infoLeft = 0;


    });
    $('#stop').click(function() { apiswf.rdio_stop(); });
    $('#pause').click(function() {
        apiswf.rdio_pause();
        $(this).hide();
        $('#play').show();
        $("#info-container .info").hide();
    });
    $('#previous').click(function() { apiswf.rdio_previous(); infoLeft = 0;apiswf.rdio_setRepeat(0); });
    $('#next').click(function() { apiswf.rdio_next(); infoLeft = 0;apiswf.rdio_setRepeat(0);});

    setInterval(function(){
        //console.log(infoWidth, infoLeft);
        $("#info-container .info").css('left', -infoLeft + 'px');
        infoLeft = (infoLeft+10)%infoWidth;
    }, 500);
});


// the global callback object
var callback_object = {};

callback_object.ready = function ready(user) {
    // Called once the API SWF has loaded and is ready to accept method calls.

    // find the embed/object element
    apiswf = $('#apiswf').get(0);

    apiswf.rdio_startFrequencyAnalyzer({
        frequencies: '10-band',
        period: 100
    });

    if (user == null) {
        $('#nobody').show();
    } else if (user.isSubscriber) {
        $('#subscriber').show();
    } else if (user.isTrial) {
        $('#trial').show();
    } else if (user.isFree) {
        $('#remaining').text(user.freeRemaining);
        $('#free').show();
    } else {
        $('#nobody').show();
    }

    console.log(user);
}

callback_object.freeRemainingChanged = function freeRemainingChanged(remaining) {
    $('#remaining').text(remaining);
}

callback_object.playStateChanged = function playStateChanged(playState) {
    // The playback state has changed.
    // The state can be: 0 - paused, 1 - playing, 2 - stopped, 3 - buffering or 4 - paused.
    $('#playState').text(playState);
}

callback_object.playingTrackChanged = function playingTrackChanged(playingTrack, sourcePosition) {
    // The currently playing track has changed.
    // Track metadata is provided as playingTrack and the position within the playing source as sourcePosition.
    if (playingTrack != null) {
        /*$('#track').text(playingTrack['name']);
        $('#album').text(playingTrack['album']);
        $('#artist').text(playingTrack['artist']);
        $('#art').attr('src', playingTrack['icon']);*/
        $('#info-container .info').text(playingTrack['artist'] + ' - ' + playingTrack['name'] + ' - ' + playingTrack['album']);
    }
}

callback_object.playingSourceChanged = function playingSourceChanged(playingSource) {
    // The currently playing source changed.
    // The source metadata, including a track listing is inside playingSource.
}

callback_object.volumeChanged = function volumeChanged(volume) {
    // The volume changed to volume, a number between 0 and 1.
}

callback_object.muteChanged = function muteChanged(mute) {
    // Mute was changed. mute will either be true (for muting enabled) or false (for muting disabled).
}

callback_object.positionChanged = function positionChanged(position) {
    //The position within the track changed to position seconds.
    // This happens both in response to a seek and during playback.
    $('#position').text(position);
}

callback_object.queueChanged = function queueChanged(newQueue) {
    // The queue has changed to newQueue.
}

callback_object.shuffleChanged = function shuffleChanged(shuffle) {
    // The shuffle mode has changed.
    // shuffle is a boolean, true for shuffle, false for normal playback order.
}

callback_object.repeatChanged = function repeatChanged(repeatMode) {
    // The repeat mode change.
    // repeatMode will be one of: 0: no-repeat, 1: track-repeat or 2: whole-source-repeat.
}

callback_object.playingSomewhereElse = function playingSomewhereElse() {
    // An Rdio user can only play from one location at a time.
    // If playback begins somewhere else then playback will stop and this callback will be called.
}

callback_object.updateFrequencyData = function updateFrequencyData(arrayAsString) {
    // Called with frequency information after apiswf.rdio_startFrequencyAnalyzer(options) is called.
    // arrayAsString is a list of comma separated floats.

    var arr = arrayAsString.split(',');

    $('#freq div').each(function(i) {
        $(this).width(parseInt(parseFloat(arr[i])*500));
    })
}



/*$(document).ready(function(){
    //console.log("Rdio loaded");

    $.getJSON('rdio.php', {"action":"getToken"}, function(json){
        if(!json.success) {
            console.log("Error Accured on the Rdio side");
        }
        rdioToken = json.token;
        // @todo Make an action if user's waiting for this ajax response
    });

});*/