<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Icons (MDI) -->
    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
            border: none;
        }
        .card-header {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        .form-label i {
            color: #0d6efd;
        }
        textarea {
            resize: none;
            height: 100px;
        }
        .btn-primary {
            font-weight: 500;
            font-size: 1.05rem;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        {{-- <a class="navbar-brand text-primary fw-bold" href="#">
            <i class="mdi mdi-wrench-outline"></i> MaintenanceRepairSystem
        </a> --}}
        <a class="navbar-brand fw-bold" href="#">
            <i class="mdi mdi-wrench-outline" style="color: #838382;"></i>
            <span style="color: #45484d;">MaintenanceRepairSystem</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center text-danger" href="/logout" title="Logout">
                        <span class="mdi mdi-logout mdi-24px"></span>
                        <span class="ms-1 d-none d-lg-inline">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0"><i class="mdi mdi-clipboard-text"></i> ฟอร์มแจ้งซ่อม</h5>
                </div>
                <div class="card-body p-4">

                    <form action="/repair/submit" method="POST" onsubmit="return validateForm();" enctype="multipart/form-data">
                        @csrf

                        {{-- <input type="hidden" name="branchname" value="{{ $branchname }}"> --}}
                        {{-- <input type="hidden" name="zonename" value="{{ $zonename }}"> --}}

                        <input type="hidden" name="branch" value="{{ $branchname }}">
                        {{-- <input type="hidden" name="branchname" value="{{ $branchname}}"> --}}
                        <input type="hidden" name="zone" value="{{ $zonename}}">

                        {{-- <input type="hidden" name="name" value="{{ $name }}"> --}}

                        <!-- อุปกรณ์ -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-tools"></i> เลือกอุปกรณ์ที่ต้องการแจ้งซ่อม
                            </label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="">-- เลือกอุปกรณ์ --</option>
                                @foreach ($equipment as $eqm)
                                    <option value="{{ $eqm->equipmentId }}">{{ $eqm->equipmentName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- รายละเอียด -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-note-text-outline"></i> รายละเอียดแจ้งซ่อม
                            </label>
                            <textarea name="detail" class="form-control" placeholder="ระบุรายละเอียด..." required></textarea>
                        </div>

                        <!-- อีเมลสาขา -->
                        {{-- <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email-outline"></i> เลือกอีเมลสาขา
                            </label>
                            <select name="email1" class="form-select" required>
                                <option value="">-- เลือกอีเมลสาขา --</option>
                                @foreach ($branchmail as $mail1)
                                    <option value="{{ $mail1->email }}">{{ $mail1->email }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- ใช้อันนี้เมลสาขา --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email-outline"></i> อีเมลสาขา
                            </label>
                            <!-- แสดงอีเมลที่ส่งมาจาก Controller โดยอัตโนมัติ -->

                            @if ($branchEmail === null)
                             <input type="hidden" name="email1" value="example@mail.com">
                              <p class="form-control-plaintext">ไม่มีอีเมลสาขา</p>
                            @else
                                <input type="hidden" name="email1" value="{{ $branchEmail}}">
                                 <p class="form-control-plaintext">{{ $branchEmail}}</p>
                            @endif
                            <!-- ซ่อนค่าอีเมลไว้ใน hidden input เพื่อส่งข้อมูลไปกับฟอร์ม -->
                            {{-- <input type="hidden" name="email1" value="{{ $branchEmail}}"> --}}
                        </div>

                        <!-- อีเมลโซน -->
                        {{-- <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email-multiple-outline"></i> เลือกอีเมลโซน
                            </label>
                            <select name="email2" class="form-select" required>
                                <option value="">-- เลือกอีเมลโซน --</option>
                                @foreach ($zoneEmail as $mail2)
                                    <option value="{{ $mail2->email }}">{{ $mail2->email }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email-multiple-outline"></i> อีเมลโซน
                            </label>
                            <!-- แสดงอีเมลที่ส่งมาจาก Controller โดยอัตโนมัติ -->
                            <p class="form-control-plaintext">{{ $zoneEmail }}</p>
                            <!-- ซ่อนค่าอีเมลไว้ใน hidden input เพื่อส่งข้อมูลไปกับฟอร์ม -->
                            <input type="hidden" name="email2" value="{{ $zoneEmail }}">
                        </div>

                        <!-- อีเมลแจ้งซ่อม -->
                        {{-- <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email-alert-outline"></i> เมลแจ้งซ่อม
                            </label>
                            <select name="email3" class="form-select" required>
                                <option value="">-- เลือกเมลแจ้งซ่อม --</option>
                                <option value="tanadesign.service@gmail.com">tanadesign.service@gmail.com - ตกแต่งภายใน</option>
                                <option value="pm2storetana@gmail.com">pm2storetana@gmail.com - เมลสโต</option>
                                <option value="chavanlak1806@gmail.com">chavanlak1806@gmail.com - dummy</option>
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email-alert-outline"></i> เมลแจ้งซ่อม
                            </label>
                            <!-- แสดงอีเมลที่ดึงมาโดยอัตโนมัติ -->
                            <p class="form-control-plaintext">{{ $emailRepair->emailRepair }}</p>
                            <!-- ซ่อนค่าอีเมลไว้ใน hidden input เพื่อส่งข้อมูลไปกับฟอร์ม -->
                            <input type="hidden" name="email3" value="{{ $emailRepair->emailRepair }}">
                        </div>

                        <!-- อัพโหลดไฟล์ -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-file-image"></i> แนบรูปภาพ / ไฟล์ (ถ้ามี)
                            </label>
                            <input type="file" name="filepic[]" class="form-control" multiple>
                        </div>

                        <!-- ปุ่ม -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="mdi mdi-send"></i> ส่งข้อมูลแจ้งซ่อม
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function validateForm() {
        const category = document.getElementById('category').value;
        if (!category) {
            alert('กรุณาเลือกอุปกรณ์ที่ต้องการแจ้งซ่อม');
            return false;
        }
        return true;
    }
</script>

</body>
</html>
