'use strict';

var helper = {
    setLoader: function(aElement, aIsLoading) {
        aIsLoading
            ? aElement.addClass('sys_disabled')
            : aElement.removeClass('sys_disabled');
    },

    isLoading: function(aElement) {
        return aElement.hasClass('sys_disabled');
    }
};

function getIp(comment_id)
{
    $.post('/ua/sajax/viewip/', {'comment_id':comment_id},
        function(json){
        $("#comment_block").remove();
        if ( json == 'error' )
        {
            json = 'Для перегляду необхідно авторизуватись!';
            //window.location.assign('/');
            $('#back-top a').click();
            $('.top_avtor a.dropdown-toggle').click();
            return false;
        }
        var html_insert = '<div id="comment_block" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="myModalLabel">IP автора коментаря</h3></div><div class="modal-body"><div>'+json+'</div></div>';
        $('#fb-root').before(html_insert);
        $('#comment_block').modal('show');
    });
}

$(document).ready(function() {

    var pollCnatiner = $('#poll_container');
    $.ajax({
        url: '/ajax/pollsajax/getpoll/',
        data: '',
        type: 'POST',
        dataType: 'json',
        success: function(data) {

            if (!sys_funcs.responceStatus(data)) {
                alert(sys_funcs.responceGetError(data))
                return;
            }

            if (data.data)
                pollCnatiner.html(data.data);
        },

        error: function(data) {
            //alert('Сталась непередбачувана помилка');
        },
    });


    $('#poll_container').on('click', '.opytuvanja_but', function() {
        if(!this.checked) {
            return;
        }

        var button = $(this);
        var formData = new FormData(button.closest('form')[0]);

        if (helper.isLoading(button))
            return;

        helper.setLoader(button, true);

        $.ajax({
            url: '/ajax/pollsajax/vote/',
            data: formData,
            type: 'POST',
            success: function(data) {
                helper.setLoader(button, false);
                var convertedData = JSON.parse(data);

                if (!sys_funcs.responceStatus(convertedData)) {
                    alert(sys_funcs.responceGetError(convertedData))
                    return;
                }

                if (convertedData.data)
                    pollCnatiner.html(convertedData.data);

            },
            error: function(data) {
                helper.setLoader(button, false);
                var convertedData = JSON.parse(data);
            },

            cache: false,
            contentType: false,
            processData: false
        });

    });

    $('#poll_news').on('click', '.opytuvanja_but', function() {

        var pollNewsCnatiner = $('#poll_news');
        if(!this.checked) {
            return;
        }

        var button = $(this);
        var formData = new FormData(button.closest('form')[0]);

        if (helper.isLoading(button))
            return;

        helper.setLoader(button, true);

        $.ajax({
            url: '/ajax/pollsajax/vote/',
            data: formData,
            type: 'POST',
            success: function(data) {
                helper.setLoader(button, false);
                var convertedData = JSON.parse(data);

                if (!sys_funcs.responceStatus(convertedData)) {
                    alert(sys_funcs.responceGetError(convertedData))
                    return;
                }

                if (convertedData.data)
                    pollNewsCnatiner.html(convertedData.data);

            },
            error: function(data) {
                helper.setLoader(button, false);
                var convertedData = JSON.parse(data);
            },

            cache: false,
            contentType: false,
            processData: false
        });

    });

});
