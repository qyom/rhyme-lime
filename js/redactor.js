/**
 * Created with JetBrains PhpStorm.
 * User: Sargis
 * Date: 7/14/13
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */
function getCurrWord(point){
    var str_value = $('#notepad').val();
    //alert(str_value);
    //alert(point);
    var start = point;
    var end   = point;
    console.log(str_value.charAt(start));
    if(str_value.charAt(start) == ' ' || str_value.charAt(start) == ''){
        start = start - 2;
    }
    while(str_value.charAt(start) != ' ' && start>0){
        start--;
    }

    while(str_value.charAt(end) != ' ' && end <= str_value.lenght){
        end++;
    }

    //alert(start +"-"+end );
    //alert(str_value.substring(start,end));
    start++;
    return str_value.substring(start,end);
}
$(document).ready(function() {
});