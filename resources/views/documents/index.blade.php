@extends('layouts.app')

@section('content')
<div class="container">
    <style>
        body {
            font-family: 'HomePageFont', sans-serif;
            background-color: #f8f9fa;
        }
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
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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
            opacity: 1;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar.collapsed a span {
            display: none;
        }
        .sidebar a:hover {
            background-color: #575d63;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
            padding-bottom: 60px;
            transition: margin-left 0.3s;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .content.collapsed {
            margin-left: 70px;
            padding-bottom: 60px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: scale(1.05);
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: scale(1.05);
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .step-navigation {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .pagination .page-link {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .pagination .page-link:hover {
            background-color: #007bff;
            color: white;
        }
        .pagination .page-link i {
            font-size: 10px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            .sidebar.collapsed {
                width: 60px;
            }
            .content {
                margin-left: 70px;
            }
            .content.collapsed {
                margin-left: 70px;
            }
            .sidebar .profile-img,
            .sidebar .profile-name,
            .sidebar a span {
                display: none;
            }
            .sidebar a {
                justify-content: center;
            }
        }
        @media (max-width: 576px) {
            .content {
                margin-left: 0;
                padding: 10px;
            }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                display: flex;
                justify-content: space-around;
                padding: 10px 0;
            }
            .sidebar a {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>

    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="content" id="content">
        <h1 style="margin-bottom: 20px;">ระบบส่งเอกสาร {{ Auth::user()->name }}</h1>
        <form id="multiStepForm" action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 30px;">
            @csrf
            <!-- Step 1 -->
            <div class="step active" id="step1">
                <div class="form-group">
                    <label for="title">ชื่อโครงการ</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="org_return">หน่วยงานเจ้าของโครงการ</label>
                    <select name="org_return" class="form-control" required>
                        <option value="">เลือกหน่วยงาน</option>
                        <option value="1">สภาผู้แทนนิสิต องค์การนิสิตฯ</option>
                        <option value="2">องค์การบริหาร องค์การนิสิตฯ</option>
                        <option value="สโมสรนิสิตคณะวิศวกรรมศาสตร์ ศรีราชา">สโมสรนิสิตคณะวิศวกรรมศาสตร์ศรีราชา</option>
                        <option value="สโมสรนิสิตคณะวิทยาศาสตร์ ศรีราชา">สโมสรนิสิตคณะวิทยาศาสตร์ ศรีราชา</option>
                        <option value="สโมสรนิสิตคณะวิทยาการจัดการ">สโมสรนิสิตคณะวิทยาการจัดการ</option>
                        <option value="สโมสรนิสิตคณะพาณิชยนาวีนานาชาติ">สโมสรนิสิตคณะพาณชยนาวีนานาชาติ</option>
                        <option value="สโมสรนิสิตคณะเศรษฐศาสตร์ ศรีราชา">สโมสรนิสิตคณะเศรษฐศาสตร์ ศรีราชา</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">ไฟล์เอกสารที่ส่งกลับ</label>
                    <input type="file" name="file" class="form-control" required>
                </div>

                <div class="step-navigation">
                    <button type="button" class="btn btn-primary" onclick="nextStep()">ถัดไป</button>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="step" id="step2">
                <div class="form-group">
                    <label for="status">สถานะ</label>
                    <select name="status" class="form-control" required>
                        <option value="ผ่านแล้ว">ผ่านแล้ว</option>
                        <option value="แก้ไข">แก้ไข</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <textarea name="remark" class="form-control" rows="3" required></textarea>
                </div>
                <div class="step-navigation">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">ย้อนกลับ</button>
                    <button type="submit" class="btn btn-primary">ส่งเอกสาร</button>
                </div>
            </div>
        </form>

        <!-- New Card for the Table -->
        <div class="card" style="margin-top: 30px;">
            <div class="card-header">
                <h5>เอกสารที่ส่งแล้ว</h5>
            </div>
            <div class="card-body">
                <!-- Wrap the table in a div for scrolling -->
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อโครงการ</th>
                                <th>ชื่อไฟล์</th>
                                {{-- <th>หน่วยงานผู้รับ</th> --}}
                                <th>สถานะ</th>
                                <th>remark</th>
                                <th>วันที่ส่ง</th>
                                {{-- <th>สร้างโดย</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->title }}</td>
                                <td><a href="{{ Storage::url($document->file_path) }}">{{ $document->file_name }}</a></td>
                                {{-- <td>{{ $document->org_return }}</td> --}}
                                <td>{{ $document->status }}</td>
                                <td>{{ $document->remark }}</td>
                                <td>{{ $document->updated_at }}</td>
                                {{-- <td>{{ $document->user ? $document->user->name : 'No User' }}</td> --}}
                            </tr>
                            @endforeach
                            @if($documents->isEmpty())
                            <tr>
                                <td colspan="7" style="text-align: center;">ไม่มีเอกสารที่แสดง</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let currentStep = 1;

    function showStep(step) {
        document.querySelectorAll('.step').forEach((element, index) => {
            element.classList.remove('active');
            if (index + 1 === step) {
                element.classList.add('active');
            }
        });
    }

    function nextStep() {
        currentStep++;
        showStep(currentStep);
    }

    function prevStep() {
        currentStep--;
        showStep(currentStep);
    }

    function changeItemsPerPage() {
        const itemsPerPage = document.getElementById('itemsPerPage').value;
        window.location.href = `?itemsPerPage=${itemsPerPage}`;
    }

    // JavaScript to toggle sidebar visibility
    document.getElementById('burger-menu').addEventListener('click', function() {
        var sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('collapsed');
    });
</script>

@endsection

<!-- Include Footer -->
@include('partials.footer')
