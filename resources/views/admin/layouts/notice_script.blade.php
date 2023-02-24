<script src="{{ mix('js/app.js') }}"></script>
<script>
@if(isset($logged_in_admin->id))

    // Echo.channel('events')
    //     .listen('BotNotification', (e) => console.log(e.message));

    // Echo.join('events')
    //     .listen('RealTimeMessage', (e) => console.log('Presence RealTimeMessage: ' + e.message));

    // Echo.private('events')
    //     .listen('RealTimeMessage', (e) => console.log('Private RealTimeMessage: ' + e.message));

    Echo.private(`App.Models.Admin.{{ $logged_in_admin->id }}`)
        .notification((notify) => {
            // console.log(notify);
            let counter = parseInt($('#notifications .notify-count').text()) || 0;
            if (0 == counter) {
                counter = 1;
            }
            else if (0 < counter && counter < 99) {
                counter = counter + 1;
            }
            else {
                counter = '99+';
            }
            $('#notifications .notify-count').text(counter);
            $('.sidebar-notify-number').text(counter);

            let new_notice_html =
                '<a class="dropdown-item noty-content '+ notify.status_class +'" id="' + notify.id + '" href="' + notify.reference_url + '">' +
                    '<div class="head">' +
                        '<b class="username">' + notify.reference_id + '</b>' +
                        '<span class="noti-date">' + notify.updated_at + '</span>' +
                    '</div>' +
                    '<div class="content">'+ notify.data +'</div>' +
                    '<div class="footer">' +
                        '<div class="tag '+ notify.label_class +'">'+ notify.label_title +'</div>' +
                    '</div>' +
                '</a>';
            $('#notification-list-items').prepend(new_notice_html);
        });

    // console.log(Echo.connector);

    $(document).on("click", '#notification-list-items .new', function(event) {
        event.preventDefault();

        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        let notice_id  = $(this).attr('id');
        let ref_href   = $(this).attr('href');

        $.ajax({
            url: "/admin/notifications/ajax-mark-as-read",
            type: "POST",
            data: {
                id: notice_id,
                _token: csrf_token
            },
            success: function(response) {
                window.location.href = ref_href;
            },
            error: function(error) {
            }
        });
    });
@endif
</script>
<style>
    #notification-list-items + .read-more:hover {
        text-decoration: none;
    }

    div.phpdebugbar .selectize-input {
        min-height: auto;
    }
</style>
