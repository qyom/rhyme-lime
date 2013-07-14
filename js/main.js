/**
 * Created with JetBrains PhpStorm.
 * User: artur
 * Date: 7/14/13
 * Time: 7:01 AM
 * To change this template use File | Settings | File Templates.
 */
var GLOBAL = {};
var GLOBAL_WORDS = {God:{rhymes:{green:[],blue:[],orange:[],red:['lil','lul'],gray:[]}}};
$(document).ready(function() {
    function getRhymes(curr_obj){
        var selected = curr_obj.getSelection();
        var cur_word = getCurrWord(selected.start);
        GLOBAL.curentWord = cur_word;
        highlight([cur_word]);
        if(GLOBAL_WORDS.hasOwnProperty(cur_word)){
            sugestionAlert(GLOBAL_WORDS[cur_word]);
        }else{
            $.getJSON(window.location, {word: cur_word}, function(json) {
                if(json.success){
                //console.log(json);
                    GLOBAL_WORDS[cur_word] = json;
                    sugestionAlert(GLOBAL_WORDS[cur_word])
                }else{
                    alert("error");
                }
            });
        }
    }
    function sugestionAlert(obj_word){
        $('.main-word').html(GLOBAL.curentWord);
        var html = ""
        for (var index in obj_word.rhyme) {
            if (obj_word.rhyme.hasOwnProperty(index) && obj_word.rhyme[index].length>0)
            {
                html = html + '<div class="'+index+' line">'
                for (var i=0; i<obj_word.rhyme[index].length; i++) {
                    html = html + "<span>"+obj_word.rhyme[index][i]+"</span>";
                }
                html = html + "</div>";
            }
        }
        $('.sugestion').html(html);
    }
    function getSynonyms(curr_obj){
        var selected = curr_obj.getSelection();
        var cur_word = getCurrWord(selected.start);
        highlight([cur_word]);
        showSynonyms();
    }
    function showSynonyms(){
        alert("showing sinonims");
    }
    function highlight(words){
        console.log(words);
        $("#notepad").highlightTextarea('disable');
        if(words[0] != ' ' && words[0] != ''){
            $("#notepad").highlightTextarea('setWords', words);
            $("#notepad").highlightTextarea('enable');
        }
    }

    $("#notepad").highlightTextarea({
        words: [],
        color: "#0b960b"
    });
    $('#notepad').keyup(function(){
                    getRhymes($(this));
                }).click(function(){
                    getRhymes($(this));
                }).bind('contextmenu', function() {
                    getSynonyms($(this));
                    return false;
                });
        /*
        .mousedown(function(event) {
        console.log($(this).getSelection());
        switch (event.which) {
            case 1:
                getRhymes($(this));
                break;
            case 2:
                getSynonyms($(this));
                break;
            case 3:
                getSynonyms($(this));
                break;
            default:
                getRhymes($(this));
        }
    });*/
});