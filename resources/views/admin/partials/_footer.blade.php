<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                @php
                    $startyear = 2020;
                    $endyear = date('Y');
                    $year = $startyear == $endyear ? $endyear : $startyear . " - " . $endyear;
                @endphp
                Copyright © {{$year}}  All rights reserved <a href="https://websitediewerkt.nl" target="_blank">Website Die Werkt</a>.
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</div>
