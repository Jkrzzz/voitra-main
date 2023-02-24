<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('/user/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/user/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('/user/css/common.css') }}">
<link rel="stylesheet" href="{{ asset('/user/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('/user/css/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('/user/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('/user/css/style.css') }}?v=22">
<link rel="stylesheet" href="{{ asset('/user/css/audio.css') }}?v=22">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/user/images/icon.png') }}?v=8">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
@if (Auth::check())
    <link rel="stylesheet" href="{{ asset('/user/css/user.css') }}?v=25">
    <link rel="stylesheet" href="{{ asset('/user/css/mobile.css') }}?v=22">
@endif
@if (View::hasSection('mining'))
    <link rel="stylesheet" href="{{ asset('/user/css/user.css') }}?v=0909">
    <link rel="stylesheet" href="{{ asset('/user/css/mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/mining.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" 
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endif
<script src="{{ asset('/user/js/jquery.min.js') }}"></script>
<script src="{{ asset('/user/js/jquery-ui.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="{{ asset('/user/js/popper.min.js') }}"></script>
<script src="{{ asset('/user/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/user/js/jquery.sticky.js')}} "></script>
<script src="{{ asset('/user/js/dataTables.min.js')}} "></script>
<script src="{{ asset('/user/js/audio.js')}}?v=22"></script>
@if (View::hasSection('mining'))
    <script src="{{ asset('/user/js/mining.js')}}"></script>
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N6JH4BR');</script>
<!-- End Google Tag Manager -->
