<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content.collapsed {
            margin-left: 70px;
        }
        .toggle-btn {
            position: absolute;
            top: 10px;
            left: 260px;
            background-color: #343a40;
            color: white;
            border: none;
            cursor: pointer;
            transition: left 0.3s;
        }
        .toggle-btn.collapsed {
            left: 70px;
        }
        body {
            font-family: 'YourPreferredFont', sans-serif;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 70px;
            }
            .toggle-btn {
                left: 70px;
            }
        }

        @media (max-width: 576px) {
            .content {
                margin-left: 0;
            }
            .toggle-btn {
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="content" id="content">
        <h1>Welcome to Home Page!</h1>
        <p>You have successfully logged in.</p>
    </div>

    <!-- Include Footer -->
    @include('partials.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.menu-link').click(function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                if (url) {
                    // Change the URL in the browser
                    window.location.href = url;
                } else {
                    var href = $(this).attr('href');
                    if (href && href !== '#') {
                        window.location.href = href;
                    } else {
                        console.log("No URL specified for this link.");
                    }
                }
            });
        });
    </script>
</body>
</html>
