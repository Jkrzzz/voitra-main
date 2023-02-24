$(function() {
    // var getDate = function() {
    //     let init = 3;
    //     var date = new Date((new Date()).getTime() + 3 * 24 * 60 * 60 * 1000);
    //     if (date.getDay() == 0) {
    //         date = new Date((new Date()).getTime() + 4 * 24 * 60 * 60 * 1000);
    //     } else if (date.getDay() == 6) {
    //         date = new Date((new Date()).getTime() + 5 * 24 * 60 * 60 * 1000);
    //     }
    //     return date;
    // }
    $.datepicker.regional['ja'] = {
        closeText: '閉じる',
        prevText: '&#x3c;前',
        nextText: '次&#x3e;',
        currentText: '今日',
        monthNames: ['1月','2月','3月','4月','5月','6月',
            '7月','8月','9月','10月','11月','12月'],
        monthNamesShort: ['1月','2月','3月','4月','5月','6月',
            '7月','8月','9月','10月','11月','12月'],
        dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
        dayNamesShort: ['日','月','火','水','木','金','土'],
        dayNamesMin: ['日','月','火','水','木','金','土'],
        weekHeader: '週',
        dateFormat: 'yy/mm/dd',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: '年'};
    let disable_days = []
    $.datepicker.setDefaults($.datepicker.regional['ja']);
    $(document).on('click', '#request', function(e) {
        e.preventDefault();
        $("#confirm_modal img").attr('src', '/user/images/icon-success.png');
        $("#confirm_modal .notification-title").html(
            '納品希望日確認'
        );
        $("#confirm_modal .notification-body").html(
            '入力した納品希望日で予約します。よろしいでしょうか。'
        );
        $('#action #text-prev').html('いいえ');
        $('#action #text').html('はい');
        $('#action').addClass('request-order');
        $("#confirm_modal").modal("show");
    })
    $(document).on('click', '.request-order', function(e) {
        $("body").addClass("load");
        $('#request-brushup').submit();
    })
    function disableDays(date) {
        const string = $.datepicker.formatDate('yy-mm-dd', date);
        return [disable_days.indexOf(string) == -1]
    }

    function noDisableDaysOrHolidays(date) {
        const noWeekend = $.datepicker.noWeekends(date);
        if (noWeekend[0]) {
            return disableDays(date);
        } else {
            return noWeekend;
        }
    }
    function setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disableDays) {
        const todayNow = new Date()
        const todayEnd = new Date()
        todayEnd.setHours(workEndTime.split(':')[0])
        todayEnd.setMinutes(workEndTime.split(':')[1])
        todayEnd.setSeconds(0)
        let nearestDate
        if (todayNow < todayEnd) {
            nearestDate = addDays(todayNow, parseFloat(dayDelay))
        } else {
            nearestDate = addDays(todayNow, parseFloat(dayDelay) + 1)
        }
        const datePlus = Math.ceil((parseFloat(totalDurationProcessing) + parseFloat(orderPlusTime)) / parseFloat(timeProcessingDaily))
        nearestDate = addDays(nearestDate, datePlus)
        let workDayArray = getDates(todayNow, nearestDate)
        for (let i = 0; i < workDayArray.length; i++) {
            const day = workDayArray[i]
            if (day.getDay() == 6 || day.getDay() == 0 || disableDays.includes(formatDate(day))) {
                workDayArray.push(addDays(workDayArray[workDayArray.length - 1], 1))
                workDayArray.splice(i, 1);
                i--
            }
        }
        nearestDate = workDayArray[workDayArray.length - 1]
        let defaultWorkDayArray = [nearestDate, addDays(nearestDate, 1)]
        for (let i = 0; i < defaultWorkDayArray.length; i++) {
            const day = defaultWorkDayArray[i]
            if (day.getDay() == 6 || day.getDay() == 0 || disableDays.includes(formatDate(day))) {
                defaultWorkDayArray.push(addDays(defaultWorkDayArray[defaultWorkDayArray.length - 1], 1))
                defaultWorkDayArray.splice(i, 1);
                i--
            }
        }
        const defaultDate = defaultWorkDayArray[defaultWorkDayArray.length - 1]
        $('.date').datepicker({
            dateFormat: "yy/mm/dd",
            minDate: nearestDate,
            beforeShowDay: noDisableDaysOrHolidays
        }).datepicker('setDate',defaultDate);;
    }
    fetch('https://holidays-jp.github.io/api/v1/date.json')
        .then(response => response.json())
        .then((data) => {
            // $('#loading').hide()
            // $('#loading').prev().show()
            disable_days = Object.keys(data)
            const dayOffs = JSON.parse($('input[name=day_off]').val())
            disable_days =  disable_days.concat(dayOffs)
            const workEndTime = $('input[name=time_end_daily]').val()
            const timeProcessingDaily = $('input[name=time_processing_daily]').val()
            const orderPlusTime = $('input[name=audio_duration]').val()
            const dayDelay = $('input[name=day_delay]').val()
            const totalDurationProcessing = $('input[name=total_duration_processing]').val()
            setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disable_days)
        });
    function addDays(date, days) {
        let result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    function getDates(startDate, stopDate) {
        let dateArray = [];
        let currentDate = startDate;
        while (currentDate <= stopDate) {
            dateArray.push(new Date (currentDate));
            currentDate = addDays(currentDate, 1);
        }
        return dateArray;
    }
    function formatDate(date) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
});
