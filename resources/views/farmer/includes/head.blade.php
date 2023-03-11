<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
    $currentURL = URL::current();
    $urlArr = explode("/", $currentURL);
    $urlArr = array_reverse($urlArr);

    $getHost = request()->getHost();

    $title = '';
    foreach ($urlArr as $key => $value) {
        if($value == $getHost) {
            break;
        } else {
            $title = $title . ' | ' . ucwords(str_replace("-", " ", $value));
        }
    }
?>

<title>Welcome to {{ env('APP_NAME') . $title }}</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ url('public/theme/admin/plugins/fontawesome-free/css/all.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ url('public/theme/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ url('public/theme/admin/dist/css/adminlte.min.css') }}">

<!-- jQuery -->
<script src="{{ url('public/theme/admin/plugins/jquery/jquery.min.js') }}"></script>

<!-- jquery validations -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<style>
    label.error {
         color: #dc3545;
         font-size: 14px;
    }
</style>