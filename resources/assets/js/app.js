
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
var ClipboardJS = require('clipboard');

/*
window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
*/

$(function () {
    var p = document.createElement('p'),
        styles = {
            width: '100px',
            height: '1px',
            overflowY: 'scroll'
        },
        i;
    for (i in styles) p.style[i] = styles[i];
    document.body.appendChild(p);
    window.scrollbarWidth = p.offsetWidth - p.clientWidth;
    document.body.removeChild(p);

    window.fullWidth = function () {
        return document.body.offsetWidth + window.scrollbarWidth;
    };
    
    $('.dropdown').on('show.bs.dropdown', function () {
        if (window.fullWidth() >= 768) {
            $(this).find('.dropdown-menu')
                .first()
                .stop(true, true)
                .show(200);
        }
    });
    $('.dropdown').on('hide.bs.dropdown', function () {
        if (window.fullWidth() >= 768) {
            $(this).find('.dropdown-menu')
                .first()
                .stop(true, true)
                .hide(200, function () {
                    $(this).removeAttr('style');
                });
        }
    });
    $('.dropdown').hover(function () {
        if (window.fullWidth() >= 768) {
            $(this).trigger('show.bs.dropdown')
                .addClass('open')
                .trigger('shown.bs.dropdown')
                .find('.dropdown-toggle')
                .attr('aria-expanded', 'true');
        }
    }, function () {
        if (window.fullWidth() >= 768) {
            $(this).trigger('hide.bs.dropdown')
                .removeClass('open')
                .trigger('hidden.bs.dropdown')
                .find('.dropdown-toggle')
                .attr('aria-expanded', 'false');
        }
    });
    $('.dropdown .dropdown-toggle').on('click', function(e) {
        if (window.fullWidth() >= 768) {
            if ($(this).attr('aria-expanded') == 'true') {
                e.preventDefault();
                return false;
            }
        }
    });

    function setTooltip(btnId, message) {
        $('#' + btnId).tooltip('hide')
            .attr('data-original-title', message)
            .tooltip('show');
    }

    function hideTooltip(btnId) {
        setTimeout(function () {
            $('#' + btnId).tooltip('hide');
        }, 1000);
    }

    $('.btn-uri').tooltip({
        trigger: 'click',
        placement: 'top'
    });

    var clipboard = new ClipboardJS('.btn-uri');

    clipboard.on('success', function(e) {
        setTooltip(e.trigger.id, '已复制');
        hideTooltip(e.trigger.id);
    });
    
    clipboard.on('error', function(e) {
        setTooltip(e.trigger.id, '复制失败');
        hideTooltip(e.trigger.id);
    });
});
