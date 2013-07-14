/**
 * Created with JetBrains PhpStorm.
 * User: artur
 * Date: 7/14/13
 * Time: 7:01 AM
 * To change this template use File | Settings | File Templates.
 */
var GLOBAL = {};
var GLOBAL_WORDS = {};
$(document).ready(function() {
    function getRhymes(curr_obj){
        var selected = curr_obj.getSelection();
        var cur_word = getCurrWord(selected.start);
        GLOBAL.curentWord = cur_word;
        if(GLOBAL_WORDS.hasOwnProperty(cur_word)){
            sugestionAlert(GLOBAL_WORDS[cur_word]);
        }else{
            $.getJSON("http://rhymeline.net/index.php", {word: cur_word}, function(json) {
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
        var wordsToHL = [GLOBAL.curentWord];
        for (var index in obj_word.rhyme)
        {
            if (obj_word.rhyme.hasOwnProperty(index) && obj_word.rhyme[index].length>0)
            {
                html = html + '<div class="'+index+' line">'
                for (var i=0; i < obj_word.rhyme[index].length; i++) {
                    html = html + "<span>"+obj_word.rhyme[index][i]+"</span>";
                    if(index == "green"){
                        wordsToHL.push(obj_word.rhyme[index][i]);
                    }
                }
                html = html + "</div>";
            }
        }
        highlight(wordsToHL);
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
        if(words[0] != ' ' && words[0] != '' && words[0] != '↵'){
            $("#notepad").highlightTextarea('setWords', words);
            $("#notepad").highlightTextarea('enable');
        }
    }
    $('.sugestion span').live("click",function(){
        alert($(this).html());
    });
    $("#notepad").highlightTextarea({
        words: ["RhymeLine"],
        color: "#0b960b",
        caseSensitive: false
    });
    $('#notepad').keyup(function(e){
                    var code = (e.keyCode ? e.keyCode : e.which);
                    //if space is pressed
                    if($.inArray(code,[32,37,38,39,40]) != -1) {
                    console.log(code);
                        getRhymes($(this));
                    }
                }).click(function(){
                    getRhymes($(this));
                }).bind('contextmenu', function() {
                    getSynonyms($(this));
                    return false;
                });
});