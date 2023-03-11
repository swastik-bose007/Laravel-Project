<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
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
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ url('public/theme/coming-soon/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Background Video-->
        <video class="bg-video" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="{{ url('public/theme/coming-soon/assets/mp4/bg.mp4') }}" type="video/mp4" />
        </video>

        <!-- Masthead-->
        <div class="masthead">
            <div class="masthead-content text-white">
                <div class="container-fluid px-4 px-lg-0">
                    <h1 class="fst-italic lh-1 mb-4">{{ env('APP_NAME') }}</h1>
                    <h1 class="fst-italic lh-1 mb-4">Coming Soon</h1>
                    <p class="mb-5">We're working hard to finish the development of this site.</p>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ url('public/theme/coming-soon/js/scripts.js') }}"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
