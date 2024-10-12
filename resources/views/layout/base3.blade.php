@extends('layout.base')

@push('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        

        html {
        line-height: 1.15; /* 1 */
        -webkit-text-size-adjust: 100%; /* 2 */
        }

        body {
        margin: 0;
        }

        main {
        display: block;
        }

        h1 {
        font-size: 2em;
        margin: 0.67em 0;
        }
        hr {
        box-sizing: content-box; /* 1 */
        height: 0; /* 1 */
        overflow: visible; /* 2 */
        }
        pre {
            font-family: 'Poppins', sans-serif;
        font-size: 1em; /* 2 */
        }

        a {
        background-color: transparent;
        }

        abbr[title] {
        border-bottom: none; /* 1 */
        text-decoration: underline; /* 2 */
        text-decoration: underline dotted; /* 2 */
        }

        b,
        strong {
        font-weight: bolder;
        }

        code,
        kbd,
        samp {
            font-family: 'Poppins', sans-serif;
        font-size: 1em; /* 2 */
        }

        small {
        font-size: 80%;
        }

        sub,
        sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
        }

        sub {
        bottom: -0.25em;
        }

        sup {
        top: -0.5em;
        }

        img {
        border-style: none;
        }

        button,
        input,
        optgroup,
        select,
        textarea {
                       font-family: 'Poppins', sans-serif;
        font-size: 100%; /* 1 */
        line-height: 1.15; /* 1 */
        margin: 0; /* 2 */
        }
        button,
        input { /* 1 */
        overflow: visible;
        }

        button,
        select { /* 1 */
        text-transform: none;
        }

        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
        -webkit-appearance: button;
        }

        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
        border-style: none;
        padding: 0;
        }

        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
        outline: 1px dotted ButtonText;
        }

        fieldset {
        padding: 0.35em 0.75em 0.625em;
        }

        legend {
        box-sizing: border-box; /* 1 */
        color: inherit; /* 2 */
        display: table; /* 1 */
        max-width: 100%; /* 1 */
        padding: 0; /* 3 */
        white-space: normal; /* 1 */
        }

        progress {
        vertical-align: baseline;
        }

        textarea {
        overflow: auto;
        }


        [type="checkbox"],
        [type="radio"] {
        box-sizing: border-box; /* 1 */
        padding: 0; /* 2 */
        }

        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
        height: auto;
        }


        [type="search"] {
        -webkit-appearance: textfield; /* 1 */
        outline-offset: -2px; /* 2 */
        }


        [type="search"]::-webkit-search-decoration {
        -webkit-appearance: none;
        }


        ::-webkit-file-upload-button {
        -webkit-appearance: button; /* 1 */
        font: inherit; /* 2 */
        }

        details {
        display: block;
        }

        summary {
        display: list-item;
        }

        template {
        display: none;
        }

        [hidden] {
        display: none;
        }
            :root {
        --main-color: #1DB954;;
        --secondary-color: #191414;
        --section-padding: 20px;
        --section-background: #e9f0eb;
        --main-duration: 0.5s;
        }
        /* End Variables */

        /* Start Global Rules */
        * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        }
        html {
        scroll-behavior: smooth;
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .container {
        padding-left: 15px;
        padding-right: 15px;
        margin-left: auto;
        margin-right: auto;
        }
        /* Small */
        @media (min-width: 768px) {
        .container {
            width: 750px;
        }
        }
        /* Medium */
        @media (min-width: 992px) {
        .container {
            width: 970px;
        }
        }
        /* Large */
        @media (min-width: 1200px) {
        .container {
            width: 1170px;
        }
        }
        /* End Global Rules */
        /* Start Components */
        .special-heading {
        color: #ddebe2;
        font-size: 100px;
        text-align: center;
        font-weight: 800;
        letter-spacing: -3px;
        margin: 0;
        }
        .special-heading + p {
        margin: -30px 0 0;
        font-size: 20px;
        text-align: center;
        color: #797979;
        }
        @media (max-width: 767px) {
        .special-heading {
            font-size: 60px;
        }
        .special-heading + p {
            margin-top: -20px;
        }
        }
        /* End Components */

        /* Start Features */
        .features {
        margin-top: -40px;
        padding-top: 60px;
        padding-bottom: var(--section-padding);
        background-color: var(--section-background);
        }
        .features .container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-gap: 20px;
        }
        .features .feat {
        padding: 20px;
        text-align: center;
        }
        .features .feat i {
        color: var(--main-color);
        }
        .features .feat h3 {
        font-weight: 800;
        margin: 30px 0;
        }
        .features .feat p {
        line-height: 1.8;
        color: #777;
        font-size: 17px;
        }
        /* End Features */
        /* Start Services  */
        .services {
        padding-top: var(--section-padding);
        padding-bottom: var(--section-padding);
        }
        .services .services-content {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-gap: 30px;
        margin-top: 50px;
        }
        .services .services-content .srv {
        display: flex;
        margin-bottom: 40px;
        }
        @media (max-width: 767px) {
        .services .services-content .srv {
            flex-direction: column;
            text-align: center;
        }
        }
        .services .services-content .srv i {
        color: var(--main-color);
        flex-basis: 60px;
        }
        .services .services-content .srv .text {
        flex: 1;
        }
        .services .services-content .srv .text h3 {
        margin: 0 0 20px;
        }
        .services .services-content .srv .text p {
        color: #444;
        font-weight: 300;
        line-height: 1.6;
        }
        .services .services-content .image {
        text-align: center;
        position: relative;
        }
        .services .services-content .image::before {
        content: "";
        background-color: var(--secondary-color);
        width: 100px;
        height: calc(100% + 100px);
        top: -50px;
        position: absolute;
        right: 0;
        z-index: -1;
        }
        .services .services-content .image img {
        width: 260px;
        }
        @media (max-width: 1199px) {
        .image-column {
            display: none;
        }
        }
        /* Start Services  */
        /* Start Portfolio */
        .portfolio {
        padding-top: var(--section-padding);
        padding-bottom: var(--section-padding);
        background-color: var(--section-background);
        }
        .portfolio .portfolio-content {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-gap: 30px;
        margin-top: 80px;
        }
        .portfolio .portfolio-content .card {
        background-color: white;
        }
        .portfolio .portfolio-content .card img {
        max-width: 100%;
        }
        .portfolio .portfolio-content .card .info {
        padding: 20px;
        }
        .portfolio .portfolio-content .card .info h3 {
        margin: 0;
        }
        .portfolio .portfolio-content .card .info p {
        color: #777;
        line-height: 1.6;
        margin-bottom: 0;
        }
        /* End Portfolio */
        /* Start Contact */
        .contact {
        padding-top: var(--section-padding);
        padding-bottom: var(--section-padding);
        background-color: var(--section-background);
        }
        .contact .info {
        padding-top: var(--section-padding);
        padding-bottom: var(--section-padding);
        text-align: center;
        }
        .contact .info .label {
        font-size: 35px;
        font-weight: 800;
        color: var(--secondary-color);
        letter-spacing: -2px;
        margin-bottom: 15px;
        }
        .contact .info .link {
        display: block;
        font-size: 35px;
        font-weight: 800;
        color: var(--main-color);
        text-decoration: none;
        }
        .contact .info .social {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        font-size: 16px;
        }
        .contact .info .social i {
        margin-left: 10px;
        color: var(--secondary-color);
        }
        @media (max-width: 767px) {
        .contact .info .label,
        .contact .info .link {
            font-size: 25px;
        }
        }
        /* End Contact */   

        .logo {
            width: 200px; /* Ukuran logo */
            margin-bottom: 0px; /* Jarak antara logo dan judul */
            border-radius: 10px; /* Membuat sudut logo lebih halus */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); /* Memberikan efek bayangan */
        }
        
        .welcome-title {
            font-size: 48px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1db954;
        }
        .description {
            font-size: 18px;
            margin-bottom: 10px;
            color: #b3b3b3;
        }

    </style>
@endpush

@section('content')
		<!-- Start Features -->
		<div class="features">
            <div class="container">
            	<div class="feat">

				</div>
				<div class="feat">
                <img src="https://i.pinimg.com/564x/55/46/c0/5546c0128307873a4ffc590fda7eac16.jpg" alt="MusicDB Logo" class="logo">                
                <h1 class="welcome-title">MusicDB</h1>
                <p class=description>
                    Your ultimate platform for discovering and managing your favorite music, artists, albums, podcasts, and more.
                </p>
				</div>				
			</div>
		</div>
		<!-- End Features -->
<!-- Start Services -->
<div class="services" id="services">
    <div class="container">
        <h2 class="special-heading">Explore MusicDB</h2>
        <div class="services-content">
            <div class="col">
                <!-- Start Service -->
                <div class="srv">
                    <a href="#">
                        <i class="fas fa-music fa-2x"></i>
                        <div class="text">
                            <h3>Tracks</h3>
                            <p>Discover and explore tracks from various artists and genres.</p>
                        </div>
                    </a>
                </div>
                <div class="srv">
                    <a href="#">
                        <i class="fas fa-user fa-2x"></i>
                        <div class="text">
                            <h3>Artists</h3>
                            <p>Find information about your favorite artists and their work.</p>
                        </div>
                    </a>
                </div>
                <!-- End Service -->
            </div>
            <div class="col">
                <!-- Start Services -->
                <div class="srv">
                    <a href="#">
                        <i class="fas fa-compact-disc fa-2x"></i>
                        <div class="text">
                            <h3>Albums</h3>
                            <p>Explore albums and collections from various labels.</p>
                        </div>
                    </a>
                </div>
                <div class="srv">
                    <a href="#">
                        <i class="fas fa-building fa-2x"></i>
                        <div class="text">
                            <h3>Record Labels</h3>
                            <p>Discover record labels and the artists they produce.</p>
                        </div>
                    </a>
                </div>
                <!-- End Services -->
            </div>
            <div class="col">
                <div class="srv">
                    <a href="#">
                        <i class="fas fa-list-ul fa-2x"></i>
                        <div class="text">
                            <h3>Playlists</h3>
                            <p>Create and manage your own playlists or explore curated lists.</p>
                        </div>
                    </a>
                </div>
                <div class="srv">
                    <a href="#">
                        <i class="fas fa-tv fa-2x"></i>
                        <div class="text">
                            <h3>Shows & Episodes</h3>
                            <p>Listen to music shows and explore episode collections.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Services -->

<!-- Start Portfolio -->
<div class="portfolio" id="portfolio">
    <div class="container">
        <h2 class="special-heading">Featured Collections</h2>
        <div class="portfolio-content">
            <div class="card">
                <img src="images/portfolio-1.jpg" alt="" />
                <div class="info">
                    <h3>Top 100 Hits</h3>
                    <p>Discover the most popular tracks of all time across different genres.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/portfolio-2.jpg" alt="" />
                <div class="info">
                    <h3>Artist of the Month</h3>
                    <p>Celebrating the artist making waves in the industry this month.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/portfolio-3.jpg" alt="" />
                <div class="info">
                    <h3>New Releases</h3>
                    <p>Stay updated with the latest albums and singles from your favorite artists.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Portfolio -->

<!-- Start Contact -->
<div class="contact">
    <div class="container">
        <h2 class="special-heading">Get in Touch</h2>
        <div class="info">
            <p class="label">Reach us via email at:</p>
            <a href="mailto:support@musicdb.com?subject=Contact" class="link">support@musicdb.com</a>
            <div class="social">
                Connect with us on Social Media:
                <i class="fab fa-youtube"></i>
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
            </div>
        </div>
    </div>
</div>
<!-- End Contact -->
@endsection

@push('scripts')
    <script src="/js/bootstrap-select.min.js"></script>
@endpush
