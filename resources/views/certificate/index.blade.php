<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Sertifikat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        .upload-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .upload-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }
        
        .upload-zone {
            border: 3px dashed #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .user-preview-card {
            margin-top: 2rem;
        }
        
        .user-preview-card .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .avatar-circle-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .upload-zone:hover {
            border-color: #667eea;
            background: #e3f2fd;
            transform: translateY(-2px);
        }
        
        .upload-zone.dragover {
            border-color: #667eea;
            background: #e3f2fd;
            transform: scale(1.02);
        }
        
        .upload-icon {
            font-size: 2.5rem;
            color: #6c757d;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .upload-zone:hover .upload-icon {
            color: #667eea;
            transform: scale(1.1);
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        
        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        
        .btn-delete:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
            color: white;
        }
        
        .btn-view {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        
        .btn-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
            color: white;
        }
        
        .title-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }
        
        .badge-status {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .file-preview {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
            border: 2px solid #e9ecef;
            display: none;
        }
        
        .file-icon {
            font-size: 3rem;
            color: #dc3545;
        }
        
        .loading-spinner {
            display: none;
            color: #667eea;
        }
        
        /* DataTables Custom Styling */
        .dataTables_wrapper {
            padding: 0;
        }
        
        .dataTables_wrapper .row {
            margin-bottom: 1rem;
        }
        
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 1rem;
        }
        
        .dataTables_wrapper .dataTables_length label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #495057;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border-radius: 25px;
            padding: 8px 15px;
            border: 2px solid #e9ecef;
            margin: 0 10px;
            background: white;
            font-weight: 500;
            min-width: 80px;
            transition: all 0.3s ease;
        }
        
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: 0;
        }
        
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }
        
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #495057;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 25px;
            padding: 10px 20px;
            border: 2px solid #e9ecef;
            margin-left: 10px;
            background: white;
            font-weight: 500;
            min-width: 300px;
            transition: all 0.3s ease;
        }
        
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: 0;
        }
        
        .dataTables_wrapper .dataTables_info {
            font-weight: 500;
            color: #6c757d;
            padding-top: 1rem;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 25px;
            margin: 0 2px;
            padding: 8px 15px;
            border: 2px solid #e9ecef;
            background: white;
            color: #495057;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f8f9fa;
            border-color: #667eea;
            color: #667eea;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: white !important;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background: #f8f9fa !important;
            border-color: #dee2e6 !important;
            color: #6c757d !important;
        }
        
        /* Custom DataTables Header */
        .dataTables-header {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
            border-bottom: 2px solid #e9ecef;
        }
        
        .dataTables-controls {
            display: flex;
            justify-content: between;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .dataTables-controls .left-controls,
        .dataTables-controls .right-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_filter input {
                min-width: 200px;
            }
            
            .dataTables-controls {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <div class="container-fluid">
            <!-- Upload Form Section -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10 col-md-12">
                    <div class="upload-card">
                        <div class="text-center mb-4">
                            <h2 class="title-gradient fw-bold">
                                <i class="fas fa-user-plus me-2"></i>
                                Tambah User Baru
                            </h2>
                            <p class="text-muted">Tambah user baru dan sertifikat akan dibuat otomatis</p>
                        </div>
                        
                        <form id="userForm" action="{{ route('person.store') }}" method="POST">
                            @csrf
                            
                            <!-- User Form Fields -->
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Nama Input -->
                                            <div class="mb-4">
                                                <label for="name" class="form-label fw-bold">
                                                    <i class="fas fa-user me-2"></i>Nama Lengkap
                                                </label>
                                                <input type="text" 
                                                       class="form-control form-control-lg" 
                                                       id="name" 
                                                       name="name" 
                                                       placeholder="Masukkan nama lengkap" 
                                                       value="{{ old('name') }}"
                                                       required>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Nama akan ditampilkan di sertifikat
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <!-- Nomor HP Input -->
                                            <div class="mb-4">
                                                <label for="phone" class="form-label fw-bold">
                                                    <i class="fas fa-phone me-2"></i>Nomor HP
                                                </label>
                                                <input type="text" 
                                                       class="form-control form-control-lg" 
                                                       id="phone" 
                                                       name="phone" 
                                                       placeholder="Contoh: 08123456789" 
                                                       value="{{ old('phone') }}"
                                                       required>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Nomor HP untuk keperluan verifikasi
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Preview Card -->
                                    <div class="user-preview-card" style="display: none;">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-eye me-2"></i>
                                                    Preview User
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-user text-primary me-2"></i>
                                                            <strong>Nama:</strong>
                                                            <span id="previewName" class="ms-2 text-muted"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-phone text-primary me-2"></i>
                                                            <strong>No. HP:</strong>
                                                            <span id="previewPhone" class="ms-2 text-muted"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert alert-info mb-0 mt-3">
                                                    <i class="fas fa-certificate me-2"></i>
                                                    <small>Sertifikat akan dibuat otomatis untuk user ini</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger fade-in">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success fade-in">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <!-- Submit Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-custom btn-lg px-5">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Tambah User & Generate Sertifikat
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Data Table Section -->
            <div class="row">
                <div class="col-12">
                    <div class="upload-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3 class="title-gradient fw-bold mb-0">
                                    <i class="fas fa-users me-2"></i>
                                    Data User & Sertifikat
                                </h3>
                                <p class="text-muted">Kelola semua user dan sertifikat yang telah dibuat</p>
                            </div>
                            <div>
                                <span class="badge bg-primary fs-6">
                                    Total: {{ $certificates ? $certificates->count() : 0 }} user
                                </span>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="certificatesTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="8%">#</th>
                                        <th width="25%">Nama User</th>
                                        <th width="20%">Nomor HP</th>
                                        <th width="20%">Tanggal Dibuat</th>
                                        <th width="12%">Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($certificates && $certificates->count() > 0)
                                        @foreach($certificates as $index => $certificate)
                                            <tr>
                                                <td class="fw-bold">{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle me-3">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold">{{ $certificate->person->name ?? 'Unknown User' }}</span>
                                                            <br>
                                                            <small class="text-muted">
                                                                <i class="fas fa-certificate me-1"></i>
                                                                ID: {{ $certificate->public_id }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-phone text-success me-2"></i>
                                                        <span class="fw-medium">{{ $certificate->person->phone ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $certificate->created_at->format('d M Y') }}
                                                        <br>
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $certificate->created_at->format('H:i') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-status bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Active
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" 
                                                                class="btn btn-view btn-sm me-1" 
                                                                onclick="viewCertificate('')"
                                                                title="Lihat Sertifikat">
                                                            <i class="fas fa-eye"></i>  
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-edit btn-sm me-1" 
                                                                onclick="editUser('{{ $certificate->person->id }}')"
                                                                title="Edit User">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('certificate.destroy', $certificate->id) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Yakin ingin menghapus user dan sertifikat ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-delete btn-sm"
                                                                    title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                                <h5 class="text-muted">Belum ada user yang ditambahkan</h5>
                                                <p class="text-muted">Tambah user pertama menggunakan form di atas</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Data User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="avatar-circle-large mx-auto mb-3">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <p class="text-muted">Update informasi user</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="edit_name" 
                                   name="name" 
                                   placeholder="Masukkan nama lengkap"
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label fw-bold">
                                <i class="fas fa-phone me-2"></i>Nomor HP
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="edit_phone" 
                                   name="phone" 
                                   placeholder="Contoh: 08123456789"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="pdfInput" class="form-label fw-bold">
                                <i class="fas fa-file-pdf"></i> Sertifikat
                            </label>
                            <input type="file"
                                    class="form-control form-control-lg"
                                    id="pdfInput" 
                                    name="certificate_file" 
                                    accept=".pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#certificatesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                pageLength: 10,
                responsive: true,
                order: [[3, 'desc']] // Sort by date
            });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const previewCard = document.querySelector('.user-preview-card');
            const previewName = document.getElementById('previewName');
            const previewPhone = document.getElementById('previewPhone');
            const userForm = document.getElementById('userForm');
            const loadingSpinner = document.querySelector('.loading-spinner');
            
            // Show preview when user types
            function showPreview() {
                const name = nameInput.value.trim();
                const phone = phoneInput.value.trim();
                
                if (name || phone) {
                    previewName.textContent = name || '(Belum diisi)';
                    previewPhone.textContent = phone || '(Belum diisi)';
                    previewCard.style.display = 'block';
                    previewCard.classList.add('fade-in');
                } else {
                    previewCard.style.display = 'none';
                }
            }
            
            // Add event listeners for live preview
            nameInput.addEventListener('input', showPreview);
            phoneInput.addEventListener('input', showPreview);
            
            // Form validation and submission
            userForm.addEventListener('submit', function(e) {
                const name = nameInput.value.trim();
                const phone = phoneInput.value.trim();
                
                if (!name || !phone) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang diperlukan!');
                    return;
                }
                
                // Validate phone number format
                if (!/^[0-9+\-\s()]+$/.test(phone)) {
                    e.preventDefault();
                    alert('Format nomor HP tidak valid!');
                    return;
                }
                
                // Show loading state
                if (loadingSpinner) {
                    loadingSpinner.style.display = 'block';
                }
                document.querySelector('.btn[type="submit"]').disabled = true;
            });
        });
        
        // View Certificate Function
        function viewCertificate(public_id) {
            // Open PDF in new tab
            window.open(`/certificate/${public_id}/view`);
        }
        
        // Edit User Function
        function editUser(userId) {
            fetch(`/person/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_phone').value = data.phone;
                    document.getElementById('editForm').action = `/person/${userId}`;
                    
                    // Show modal
                    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data user');
                });
        }
    </script>
</body>
</html>