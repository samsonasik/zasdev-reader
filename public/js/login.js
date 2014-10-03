
var login = {

    init : function() {
        this.initChangeLoginType();
    },

    initChangeLoginType : function() {
        var $logins = $('.logins');

        $('#display-social-login').click(function(e) {
            e.preventDefault();
            $logins.stop().css({'margin-left' : '-100%'});
        });
        $('#display-standard-login').click(function(e) {
            e.preventDefault();
            $logins.stop().css({'margin-left' : '0'});
        });
    }

};