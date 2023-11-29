/*
jQuery Pop Menu
Version: beta
Author: Guc. http://www.gucheen.pro
Based on jQuery 2.0.3
*/

(function ($) {

    $.fn.popmenu = function (options) {

        var settings = $.extend({
            'controller': true,
            'width': '400px',
            'background': '#1b3647',
            'focusColor': '#166ba2',
            'borderRadius': '10px',
            'top': '130',
            'left': '180',
            'iconSize': '100px',
            //'color': '#f0f',
            'border': '0px'
        }, options);
        if (settings.controller === true) {
            var temp_display = 'none';
        } else {
            var temp_display = 'block';
        }
        var tar = $(this);
        var tar_body = tar.children('ul');
        var tar_list = tar_body.children('li');
        var tar_a = tar_list.children('a');
        var tar_ctrl = tar.children('.pop_ctrl');


        function setIt() {
            tar_body.css({
                'display': temp_display,
                'position': 'absolute',
                'margin-top': -settings.top,
                'margin-left': -settings.left,
                'background': settings.background,
                'width': settings.width,
                'float': 'left',
                'padding': '0',
                'border-radius': settings.borderRadius,
                'border': settings.border
            });
            
            tar_list.css({
                'display': 'block',
                //'color': '#f00',
                'float': 'left',
                'width': settings.iconSize,
                'height': settings.iconSize,
                'text-align': 'center',
                'border-radius': settings.borderRadius
            });
            tar_a.css({
                'text-decoration': 'none',
                //'color': settings.color
            });
            tar_ctrl.hover(function () {
                tar_ctrl.css('cursor', 'pointer');
            }, function () {
                tar_ctrl.css('cursor', 'default')
            });
            tar_ctrl.click(function (e) {
                e.preventDefault();
                tar_body.show('fast');
                $(document).mouseup(function (e) {
                    var _con = tar_body;
                    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
                        _con.hide();
                    }
                    //_con.hide(); some functions you want
                });
            });
            tar_list.hover(function () {
                $(this).css({
                    'background': settings.focusColor,
                    'cursor': 'pointer'
                });
            }, function () {
                $(this).css({
                    'background': settings.background,
                    'cursor': 'default'
                });
            });
        }
        return setIt();

    };

}(jQuery));

