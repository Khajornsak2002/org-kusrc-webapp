@include('partials.sidebar')

<style>
    /* Add some margin to the form to prevent overlap with the sidebar */
    #check-student-id-form {
        margin-left: 400px; /* ปรับค่าให้มากขึ้นเพื่อไม่ให้ถูก sidebar บัง */
        border: 1px solid #ccc; /* เพิ่มกรอบ */
        padding: 20px; /* เพิ่มพื้นที่ภายในกรอบ */
        border-radius: 10px; /* ทำให้มุมกรอบมนมากขึ้น */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้กรอบ */
        background-color: #f9f9f9; /* เปลี่ยนสีพื้นหลัง */
    }

    #result-container {
        display: flex; /* Use flexbox for side-by-side layout */
        margin-left: 400px; /* Align with the form */
    }

    .result-card {
        border: 1px solid #ccc; /* กรอบ */
        border-radius: 10px; /* มุมมน */
        padding: 20px; /* พื้นที่ภายใน */
        margin-right: 20px; /* ระยะห่างระหว่างการ์ด */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* เงา */
        background-color: #fff; /* สีพื้นหลัง */
        width: 45%; /* ความกว้างของการ์ด */
    }

    button {
        background-color: #007bff; /* เปลี่ยนสีปุ่ม */
        color: white; /* เปลี่ยนสีตัวอักษร */
        border: none; /* ไม่มีกรอบ */
        padding: 10px 20px; /* เพิ่มพื้นที่ภายในปุ่ม */
        border-radius: 5px; /* ทำให้มุมปุ่มมน */
        cursor: pointer; /* เปลี่ยนเคอร์เซอร์เมื่อชี้ที่ปุ่ม */
        transition: background-color 0.3s; /* เพิ่มการเปลี่ยนสีเมื่อชี้ */
    }

    button:hover {
        background-color: #0056b3; /* เปลี่ยนสีเมื่อชี้ที่ปุ่ม */
    }

    textarea {
        border: 1px solid #ccc; /* เพิ่มกรอบ */
        border-radius: 5px; /* ทำให้มุมมน */
        padding: 10px; /* เพิ่มพื้นที่ภายใน */
        width: 400px; /* กำหนดความกว้าง */
        resize: none; /* ปิดการปรับขนาด */
    }
</style>

{{-- <h2>โปรแกรมตรวจสอบรหัสนิสิต</h2> --}}
<form id="check-student-id-form">
    <h2>โปรแกรมตรวจสอบรหัสนิสิต</h2>
    <label for="student_id">รหัสนิสิต:</label>
    <textarea id="student_id" name="student_id" required rows="5"></textarea>
    <button type="submit">ตรวจสอบ</button>

    {{-- เพิ่มปุ่มสำหรับการอัปโหลดไฟล์ Excel --}}
    <input type="file" id="file-input" accept=".xlsx, .xls" style="display: none;" />
    <button id="import-excel-button" type="button">นำเข้า Excel</button>
</form>

<div id="result-container">
    <div id="summary" class="result-card">ผลลัพธ์สรุป</div>
    <div id="problems" class="result-card">รหัสนิสิตที่มีปัญหา</div>
</div>

@include('partials.footer')

<script>
    // Load student ID from localStorage when the page loads
    window.onload = function() {
        const savedStudentIds = localStorage.getItem('studentIds');
        if (savedStudentIds) {
            document.getElementById('student_id').value = savedStudentIds;
        }
    };

    document.getElementById('check-student-id-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const studentIds = document.getElementById('student_id').value.split('\n');
        localStorage.setItem('studentIds', document.getElementById('student_id').value); // Save to localStorage

        const existingIds = ['123456', '654321']; // ตัวอย่างรหัสนิสิตที่มีอยู่
        const summaryDiv = document.getElementById('summary');
        const problemsDiv = document.getElementById('problems');

        // Check for duplicates and length
        const seenIds = new Set();
        const results = [];
        let hasError = false;
        let totalEntries = studentIds.length;
        let duplicateCount = 0;
        let shortCount = 0;
        let longCount = 0;

        studentIds.forEach(id => {
            const trimmedId = id.trim();
            if (trimmedId.length === 0) return; // ข้ามบรรทัดที่ว่างเปล่า
            if (trimmedId.length < 10) {
                results.push(`รหัสนิสิต ${trimmedId} ไม่ครบ 10 หลัก`);
                shortCount++;
                hasError = true;
            } else if (trimmedId.length > 10) {
                results.push(`รหัสนิสิต ${trimmedId} เกิน 10 หลัก`);
                longCount++;
                hasError = true;
            } else if (seenIds.has(trimmedId) || existingIds.includes(trimmedId)) {
                results.push(`รหัสนิสิต ${trimmedId} ซ้ำในระบบ`);
                duplicateCount++;
                hasError = true;
            } else {
                seenIds.add(trimmedId);
            }
        });

        // Display results
        let displayResults = '';
        if (hasError) {
            // Only show counts that are greater than 0
            if (duplicateCount > 0) {
                displayResults += `รหัสนิสิตซ้ำ: ${duplicateCount} รายการ<br>`;
            }
            if (shortCount > 0) {
                displayResults += `รหัสนิสิตไม่ครบ 10 หลัก: ${shortCount} รายการ<br>`;
            }
            if (longCount > 0) {
                displayResults += `รหัสนิสิตเกิน 10 หลัก: ${longCount} รายการ<br>`;
            }
            problemsDiv.innerHTML = results.join('<br>');
        } else {
            problemsDiv.innerHTML = "ไม่มีรหัสนิสิตที่มีปัญหา";
        }

        summaryDiv.innerHTML = `ข้อมูลทั้งหมด: ${totalEntries} รายการ<br>` + displayResults;
    });
</script>

{{-- เพิ่มการนำเข้า SheetJS สำหรับการอ่านไฟล์ Excel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<script>
    document.getElementById('import-excel-button').addEventListener('click', function() {
        document.getElementById('file-input').click(); // คลิกที่ input file เมื่อปุ่มถูกกด
    });

    document.getElementById('file-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            const data = new Uint8Array(event.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            // แปลงข้อมูล Excel เป็น string และแสดงใน textarea
            const studentIds = jsonData.flat().slice(1).join('\n'); // ข้า��แถวแรก
            document.getElementById('student_id').value = studentIds;
        };

        reader.readAsArrayBuffer(file);
    });
</script>
