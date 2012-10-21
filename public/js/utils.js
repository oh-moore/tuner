function checkEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}   

var STRENGTH_TOO_SHORT=1;
var STRENGTH_WEAK=2;
var STRENGTH_GOOD=3;
var STRENGTH_STRONG=4;
function checkStrength(password){
 
    //initial strength
    var strength = 0
    
    //if the password length is less than 6, return message.
    if (password.length < 6) {
        return STRENGTH_TOO_SHORT;
    }
 
    //length is ok, lets continue.
 
    //if length is 8 characters or more, increase strength value
    if (password.length > 7) strength += 1
 
    //if password contains both lower and uppercase characters, increase strength value
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
 
    //if it has numbers and characters, increase strength value
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
 
    //if it has one special character, increase strength value
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
 
    //if it has two special characters, increase strength value
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) strength += 1
 
    //now we have calculated strength value, we can return messages
 
    //if value is less than 2
    if (strength < 2 ) {
        $('#result').removeClass()
        $('#result').addClass('weak')
        return STRENGTH_WEAK;
    } else if (strength == 2 ) {
        $('#result').removeClass()
        $('#result').addClass('good')
        return STRENGTH_GOOD;
    } else {
        $('#result').removeClass()
        $('#result').addClass('strong')
        return STRENGTH_STRONG;
    }
}


function addNotification(atitle, atext, asticky, atime)
{
                $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: atitle,
                        // (string | mandatory) the text inside the notification
                        text: atext,
                        // (string | optional) the image to display on the left
                        sticky: asticky,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: atime
                });
}

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};