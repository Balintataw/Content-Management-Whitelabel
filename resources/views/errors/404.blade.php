<html>
    <head>
        <title>404 Not Found</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            #back-button-404 {
                padding: 20px;
                border-radius: 8px;
                background-color: transparent;
                outline: none;
                box-shadow: 2px 2px grey;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">This page is not allowed to be viewed from your country.</div>
                <button id="back-button-404" type="button" class="btn btn-secondary">Go Back</button>
            </div>
        </div>
    </body>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#back-button-404").click(function() {
                window.history.back();
            });
        });
    </script>
</html>