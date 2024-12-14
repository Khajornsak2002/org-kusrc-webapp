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

    /* Responsive styles for mobile */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%; /* Full width on mobile */
            height: auto; /* Adjust height */
            position: relative; /* Change position to relative */
        }
        .sidebar.collapsed {
            width: 60px; /* Width when collapsed */
        }
        .sidebar .profile-img {
            width: 80px; /* Smaller profile image */
            height: 80px; /* Smaller profile image */
        }
        .sidebar .profile-name {
            font-size: 16px; /* Smaller font size */
            display: none; /* Hide name when collapsed */
        }
        .sidebar a {
            font-size: 16px; /* Smaller font size for links */
        }
        .sidebar.collapsed .profile-img {
            display: none; /* Hide profile image when collapsed */
        }
        .sidebar.collapsed a span {
            display: none; /* Hide text when collapsed */
        }
    }

    /* Styles for burger menu */
    .burger-menu {
        display: none; /* Hide by default */
        cursor: pointer;
        font-size: 24px;
        color: black;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1000; /* Ensure it is above other elements */
    }

    @media (max-width: 768px) {
        .burger-menu {
            display: block; /* Show burger menu on mobile */
        }
        .sidebar {
            display: none; /* Hide sidebar by default on mobile */
        }
        .sidebar.active {
            display: block; /* Show sidebar when active */
        }
    }
</style>

<!-- Burger Menu Icon -->
<div class="burger-menu" id="burger-menu">
    &#9776; <!-- Unicode for hamburger icon -->
</div>

<div class="sidebar" id="sidebar">
    <!-- Profile Section -->
    <img src="{{ route('user.image', ['id' => Auth::id()]) }}" alt="Profile Image" class="profile-img">
    <div class="profile-name">{{ Auth::user()->username }}</div>

    <!-- Menu Links -->
    <a href="/home" class="menu-link"><i class="fas fa-home"></i><span>หน้าหลัก</span></a>
    <a href="/documents" class="menu-link"><i class="fas fa-file-alt"></i><span>ระบบส่งเอกสาร</span></a>
    <a href="/document-receiving" class="menu-link"><i class="fas fa-inbox"></i><span>ระบบรับเอกสาร</span></a>
    <a href="/borrow-return" class="menu-link"><i class="fas fa-exchange-alt"></i><span>ระบบยืม-คืนครุภัณฑ์</span></a>
    <a href="#" class="menu-link"><i class="fas fa-box"></i><span>ระบบครุภัณฑ์</span></a>
    <a href="/check-student-id" class="menu-link"><i class="fas fa-id-card"></i><span>ตรวจสอบรหัสนิสิต</span></a>
    <a href="#" class="menu-link" onclick="return false;" style="pointer-events: none; color: gray;">
        <i class="fas fa-cog"></i><span>Settings</span>
    </a>
    <a href="/organization-structure" class="menu-link"><i class="fas fa-sitemap"></i><span>โครงสร้างองค์กร</span></a>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="btn btn-danger mt-3">
            <i class="fas fa-sign-out-alt"></i> Logout <!-- Added logout icon -->
        </button>
    </form>
</div>

<script>
    // JavaScript to toggle sidebar visibility
    document.getElementById('burger-menu').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    });
</script>
