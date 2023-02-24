<base href="./../">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Upsell {{ !\Illuminate\Support\Facades\Auth::guard('admin')->check() || \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1 ? 'Admin' : 'Staff'}}</title>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('./admin/assets/img/logo/logo-meta.png')}}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('./admin/assets/img/logo/logo-meta.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('./admin/assets/img/logo/logo-meta.png')}}">
<link rel="manifest" href="{{ asset('./admin/assets/favicon/manifest.json') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('./admin/assets/favicon/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('/user/css/jquery-ui.css') }}">
<link href="{{ asset('./admin/css/style.css') }}?v=202203250917" rel="stylesheet">
<link href="{{ asset('./admin/css/common.css') }}?v=202203250917" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
<script type="text/javascript" src="{{ asset('./admin/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./user/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('./user/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./admin/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./admin/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('./admin/js/common.js') }}?v=202203250917"></script>
{{-- <script type="text/javascript" src="{{ asset('./admin/js/coreui.bundle.min.js') }}?v=3.4.0"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    function convertTZ(date) {
        return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: "Asia/Tokyo"}));
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
    function formatDatetime(date) {
        const m = convertTZ(date)
        return m.getFullYear() + "/" +
            ("0" + (m.getMonth() + 1)).slice(-2) + "/" +
            ("0" + m.getDate()).slice(-2) + " " +
            ("0" + m.getHours()).slice(-2) + ":" +
            ("0" + m.getMinutes()).slice(-2) + ":" +
            ("0" + m.getSeconds()).slice(-2)
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
    function secondsFromTime(time) {
        const a = time.split(':');
        return  (+a[0]) * 60 * 60 + (+a[1]) * 60;
    }
    function secondsFromMinutes(minutes) {
        return  minutes * 60;
    }
    Array.prototype.remove = function() {
        let what, a = arguments, L = a.length, ax;
        while (L && this.length) {
            what = a[--L];
            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }
        return this;
    };
</script>
