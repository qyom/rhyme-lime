/**
 * Created with JetBrains PhpStorm.
 * User: artur
 * Date: 7/14/13
 * Time: 7:01 AM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function() {
    function getRhymes(curr_obj){
        console.log(curr_obj.getSelection());
        //alert("getting rhyme");
        var selected = curr_obj.getSelection();
        var cur_word = getCurrWord(selected.start);
        highlight([cur_word]);
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
    $("textarea").highlightTextarea({
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