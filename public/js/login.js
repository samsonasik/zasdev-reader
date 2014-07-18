
var login = {

    init : function() {
        this.initChangeLoginType();
    },

    initChangeLoginType : function() {
        var $logins = $(".logins");

        $("#display-social-login").click(function(e) {
            e.preventDefault();
            var left = $(this).closest(".standard-login").width() + 20;
            left = "-" + left + "px";
            $logins.stop().css({"margin-left" : left});
        });
        $("#display-standard-login").click(function(e) {
            e.preventDefault();
            $logins.stop().css({"margin-left" : "0"});
        });
    }

};