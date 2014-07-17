
var login = {

    init : function() {
        this.initChangeLoginType();
    },

    initChangeLoginType : function() {
        var $logins = $(".logins");

        $("#display-social-login").click(function() {
            var left = $(this).closest(".standard-login").width() + 20;
            left = "-" + left + "px";
            $logins.stop().animate({"margin-left" : left});
        });
        $("#display-standard-login").click(function() {
            $logins.stop().animate({"margin-left" : "0"});
        });
    }

};