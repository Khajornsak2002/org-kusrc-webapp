<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* กำหนดสไตล์ของ Sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
            text-align: center;
            transition: width 0.3s;
        }
        .sidebar.collapsed {
            width: 60px;
        }
        .sidebar .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
            transition: opacity 0.3s;
        }
        .sidebar.collapsed .profile-img {
            opacity: 0;
        }
        .sidebar .profile-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            transition: opacity 0.3s;
        }
        .sidebar.collapsed .profile-name {
            opacity: 0;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: flex;
            align-items: center;
            transition: opacity 0.3s;
        }
        .sidebar.collapsed a {
            opacity: 1; /* Keep icons visible */
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar.collapsed a span {
            display: none; /* Hide text when collapsed */
        }
        .sidebar a:hover {
            background-color: #575d63;
        }
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.menu-link').click(function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                if (url) {
                    $('#content').load(url, function(response, status, xhr) {
                        if (status == "error") {
                            console.log("Error loading content: " + xhr.status + " " + xhr.statusText);
                        }
                    });
                } else {
                    // If no data-url, navigate to the href if it's not '#'
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
