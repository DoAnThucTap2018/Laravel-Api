<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <base href="/">
    {{--<meta name="keywords" content="{{$meta['keywords']}}">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title id="title"></title>
    <!-- Meta tag-->
    <!-- Search Engine -->
    {{--<meta name="description" content="{{$meta['description']}}">--}}
    {{--<meta name="image" content="{{$meta['image']}}">--}}
    {{--<!-- Twitter -->--}}
    {{--<meta name="twitter:card" content="summary">--}}
    {{--<meta name="twitter:title" content="{{$meta['title']}}">--}}
    {{--<meta name="twitter:description" content="{{$meta['description']}}">--}}
    {{--<meta name="twitter:image:src" content="{{$meta['image']}}">--}}
    {{--<!-- Open Graph general (Facebook, Pinterest & Google+) -->--}}
    {{--<meta property="og:title" content="{{$meta['title']}}">--}}
    {{--<meta property="og:description" content="{{$meta['description']}}">--}}
    {{--<meta property="og:image" content="{{$meta['image']}}">--}}
    {{--<meta property="og:url" content="{{url()->full()}}">--}}
    {{--<meta property="og:site_name" content="LBMT">--}}
    {{--<meta property="og:locale" content="en_US">--}}
    {{--<meta property="og:type" content="website">--}}
    <!-- End Meta tag-->
    {{--<link rel="stylesheet" href="css/style.css">--}}
    <!-- BOOTSTRAP 4 CSS -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">--}}
    {{--<!-- font-awesome -->--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">--}}
    {{--<script src="https://js.stripe.com/v3/"></script>--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">--}}
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">--}}

    <link href='http://fonts.googleapis.com/css?family=Dosis:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="dest/css/font-awesome.min.css">
    <link rel="stylesheet" href="dest/vendors/colorbox/example3/colorbox.css">
    <link rel="stylesheet" href="dest/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="dest/rs-plugin/css/responsive.css">
    <link rel="stylesheet" title="style" href="dest/css/style.css">
    <link rel="stylesheet" href="dest/css/animate.css">
    <link rel="stylesheet" title="style" href="dest/css/huong-style.css">

</head>
<body>
<app-root></app-root>
<!-- include js files -->
<script src="dest/js/jquery.js"></script>
<script src="dest/vendors/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="dest/vendors/bxslider/jquery.bxslider.min.js"></script>
<script src="dest/vendors/colorbox/jquery.colorbox-min.js"></script>
<script src="dest/vendors/animo/Animo.js"></script>
<script src="dest/vendors/dug/dug.js"></script>
<script src="dest/js/scripts.min.js"></script>
<script src="dest/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="dest/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="dest/js/waypoints.min.js"></script>
<script src="dest/js/wow.min.js"></script>
<!--customjs-->
<script src="dest/js/custom2.js"></script>
<script>
    $(document).ready(function($) {
        $(window).scroll(function(){
            if($(this).scrollTop()>150){
                $(".header-bottom").addClass('fixNav')
            }else{
                $(".header-bottom").removeClass('fixNav')
            }}
        )
    })
</script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!-- BOOTSTRAP 4 JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- LightWidget WIDGET -->
<script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
<!-- stripe -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@php
    $key_pk=\Illuminate\Support\Facades\Config::get('settings.pk_live_key_stripe');
    if(!isset($key_pk) or empty($key_pk))
    {
        $key_pk="pk_test_7UwL5tQsWoEzRhRd6lOpzToq";
    }
@endphp
<script type="text/javascript">
    Stripe.setPublishableKey("<?php echo $key_pk ?>")
</script>

<script type="text/javascript" src="js/app/inline.bundle.js"></script>
<script type="text/javascript" src="js/app/polyfills.bundle.js"></script>
<script type="text/javascript" src="js/app/vendor.bundle.js"></script>
<script type="text/javascript" src="js/app/main.bundle.js"></script>

</body>
</html>
