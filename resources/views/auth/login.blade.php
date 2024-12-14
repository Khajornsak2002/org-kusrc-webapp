<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="https://reg2.src.ku.ac.th/doc/images/KUSRC.png" type="image/png">
</head>
<body>
    <div class="container mt-5">
        {{-- <h1>Login</h1> --}}
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login Guest</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- Remember Me checkbox -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <!-- Add a link to the registration page -->
                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}">Don't have an account? Register here</a>
                        </div>
                        <!-- Add a button for admin login -->
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.login') }}" class="btn btn-secondary btn-block">Login as Admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- แสดงข้อความแจ้งเตือนเมื่อมีการส่งสถานะการล็อกอินจาก session -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('login_status') == 'success')
                // Check if the user role is admin
                @if(auth()->user()->admin())
                    window.location.href = "{{ route('home-admin') }}"; // Redirect to admin home
                @elseif(auth()->user()->role == 'guest') // Check if the user role is guest
                    Swal.fire({
                        icon: 'info',
                        title: 'Welcome Guest',
                        text: 'You have logged in as a guest.',
                        confirmButtonText: 'OK'
                    });
                @else
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'You have successfully logged in!',
                        confirmButtonText: 'OK'
                    });
                @endif
            @elseif(session('login_status') == 'error')
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Email or password is incorrect.',
                    confirmButtonText: 'Try Again'
                });
            @endif
        });
    </script>
</body>
</html>
