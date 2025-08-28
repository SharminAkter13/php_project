<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DonorHub Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <style>
        .wrapper {
            margin: auto;
            margin-left: 180px;
        }
    </style>
</head>
<body>

    <div class="facts" data-parallax="scroll" data-image-src="assets/img/img/volunteer.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="flaticon-home"></i>
                        <div class="facts-text">
                            <h3 class="facts-plus" data-target="150">0</h3>
                            <p>Countries</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="flaticon-charity"></i>
                        <div class="facts-text">
                            <h3 class="facts-plus" data-target="400">0</h3>
                            <p>Volunteers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="flaticon-kindness"></i>
                        <div class="facts-text">
                            <h3 class="facts-dollar" data-target="10000">0</h3>
                            <p>Our Goal</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="facts-item">
                        <i class="flaticon-donation"></i>
                        <div class="facts-text">
                            <h3 class="facts-dollar" data-target="5000">0</h3>
                            <p>Raised</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('[data-target]');
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = +counter.getAttribute('data-target');
                        const isDollar = counter.classList.contains('facts-dollar');
                        const duration = 2000;
                        let startTime = null;

                        const animate = (timestamp) => {
                            if (!startTime) startTime = timestamp;
                            const progress = timestamp - startTime;
                            const increment = Math.min(progress / duration, 1);
                            const currentValue = Math.floor(increment * target);
                            
                            counter.innerText = (isDollar ? '$' : '') + currentValue;

                            if (increment < 1) {
                                requestAnimationFrame(animate);
                            } else {
                                counter.innerText = (isDollar ? '$' : '') + target;
                            }
                        };
                        
                        requestAnimationFrame(animate);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => {
                observer.observe(counter);
            });
        });
    </script>
</body>
</html>