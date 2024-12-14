@extends('layouts.app')
@include('partials.sidebar')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}">

@section('content')
<div class="container">
    <style>
        /* Set the font for the entire document */
        * {
            font-family: 'HomePageFont', sans-serif; /* Apply the font to all elements */
            font-size: 16px; /* กำหนดขนาดตัวอักษรให้เท่ากัน */
        }
        body {
            background-color: #f8f9fa;
        }
        /* New styles for the document list */
        .document-list {
            margin-top: 20px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-left: 260px;
            background-color: white;
        }
        .document-list h1 {
            color: #007bff;
            text-align: center;
            font-size: 30px;
        }
        .document-list table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            min-height: 500px;
            position: relative; /* Set position to relative for the table */
            overflow: hidden; /* Hide overflow */
        }
        .document-list th, .document-list td {
            padding: 12px;
            text-align: left;
        }
        .document-list th {
            background-color: #007bff;
            color: white;
        }
        .document-list tr:hover {
            background-color: #e9ecef;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s;
            border-radius: 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        /* New styles for advanced search */
        .advanced-search {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            height: auto;
        }
        /* Add styles for Select2 */
        .select2-container {
            width: 100% !important;
        }
        tfoot {
            border-top: 2px solid gray; /* เพิ่มกรอบด้านบน */
            border-bottom: 2px solid gray; /* เพิ่มกรอบด้านล่าง */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .document-list {
                margin-left: 0; /* Remove left margin on small screens */
                padding: 10px; /* Reduce padding */
            }
            .document-list h1 {
                font-size: 24px; /* Smaller font size for headings */
            }
            .advanced-search {
                flex-direction: column; /* Stack search fields vertically */
                height: auto; /* Ensure height is auto for mobile */
            }
            .advanced-search .col-md-3 {
                width: 100%; /* Full width for each search field */
                margin-bottom: 10px; /* Space between fields */
            }
            .btn {
                width: 100%; /* Full width buttons */
            }
            /* Adjust table for smaller screens */
            .document-list table {
                font-size: 14px; /* Smaller font size for table */
                min-height: 500px;
            }
            .document-list th, .document-list td {
                padding: 8px; /* Reduce padding for table cells */
            }
        }

        /* New styles for fixed table header */
        .document-list table {
            position: relative; /* Set position to relative for the table */
            overflow: hidden; /* Hide overflow */
        }
        .document-list thead {
            position: sticky; /* Make the header sticky */
            top: 0; /* Stick to the top */
            background-color: #007bff; /* Background color for the header */
            z-index: 10; /* Ensure it stays above other content */
        }
        .document-list th {
            color: white; /* Ensure text color is white */
        }

    </style>
    <div class="document-list">
        <h1 style="margin-bottom: 20px;">ระบบรับเอกสาร {{ Auth::user()->name }} <span id="unreadCount" style="color: red;"></span></h1>
        <div style="margin-bottom: 20px;">
            <input type="text" id="search" placeholder="ค้นหาจากชื่อโครงการ, หน่วยงานผู้รับ, สถานะ" class="form-control" onkeyup="filterDocuments()" style="width: 100%; max-width: calc(100% - 120px); height: 38px; font-size: 16px;">
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped" id="documentTable">
                <thead>
                    <tr>
                        <th>ชื่อโครงการ</th>
                        <th>ชื่อไฟล์</th>
                        {{-- <th>หน่วยงานผู้รับ</th> --}}
                        <th>สถานะ</th>
                        <th>remark</th>
                        <th>วันที่ส่ง</th>
                        <th>ส่งมาจาก</th>
                    </tr>
                </thead>
                <tbody id="documentBody">
                    <!-- เอกสารจะถูกเพิ่มที่นี่โดย JavaScript -->
                </tbody>
            </table>
        </div>
        <div style="background-color: gray; color: white; border: 1px solid gray; font-weight: bold; text-align: right; padding: 10px; border-radius: 10px; display: inline-block;">
            พบข้อมูล: <span id="visibleCount">0</span> รายการ จากทั้งหมด: <span id="totalCount">0</span> รายการ
        </div>
    </div>
    <!-- End of updated document list section -->
</div>

<!-- Include Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        fetchDocuments(); // เรียกฟังก์ชันเพื่อดึงเอกสาร

        // Define the filterDocuments function here
        window.filterDocuments = function() {
            const searchValue = $('#search').val().toLowerCase(); // Get the search input value
            $('#documentBody tr').filter(function() {
                // Filter rows based on the specified columns
                $(this).toggle(
                    $(this).children('td').eq(0).text().toLowerCase().indexOf(searchValue) > -1 || // ชื่อโครงการ
                    $(this).children('td').eq(2).text().toLowerCase().indexOf(searchValue) > -1 || // สถานะ
                    $(this).children('td').eq(5).text().toLowerCase().indexOf(searchValue) > -1 // ส่งมาจาก
                );
            });
        };

        function fetchDocuments() {
            $.ajax({
                url: '/api/documents', // URL ของ API
                method: 'GET',
                success: function(data) {
                    const documentBody = $('#documentBody');
                    documentBody.empty(); // ล้างข้อมูลเก่า
                    let visibleCount = 0;
                    let todayCount = 0; // Initialize today's count

                    const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

                    data.forEach(document => {
                        documentBody.append(`
                            <tr>
                                <td>${document.title}</td>
                                <td><a href="{{ Storage::url('${document.file_path}') }}">{{ '${document.file_name}' }}</a></td>

                                <td>${document.status}</td>
                                <td>${document.remark}</td>
                                <td>${document.updated_at}</td>
                                <td>${document.user ? document.user.name : 'No User'}</td>
                            </tr>
                        `);
                        visibleCount++;
                        if (document.updated_at.split('T')[0] === today) { // Check if the document was created today
                            todayCount++; // Increment today's count
                        }
                    });

                    $('#visibleCount').text(visibleCount);
                    $('#totalCount').text(visibleCount); // อัปเดตจำนวนทั้งหมด
                    $('#todayCount').text(todayCount); // Update today's count
                },
                error: function() {
                    console.error('Error fetching documents');
                }
            });
        }
    });
</script>
@endsection

@include('partials.footer')
