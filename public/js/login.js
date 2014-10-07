/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

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