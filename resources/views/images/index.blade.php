<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
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
        }
        
        .upload-zone {
            border: 3px dashed #dee2e6;
            border-radius: 15px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
            cursor: pointer;
            position: relative;
            overflow: hidden;
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
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .upload-zone:hover .upload-icon {
            color: #667eea;
            transform: scale(1.1);
        }
        
        .preview-container {
            margin-top: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 15px;
            border: 2px solid #e9ecef;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 400px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        .preview-image:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .file-info {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1rem;
            border-left: 4px solid #667eea;
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
        
        .btn-danger-custom {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-danger-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
            color: white;
        }
        
        .loading-spinner {
            display: none;
            color: #667eea;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .title-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Gallery Styles */
        .gallery-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .image-wrapper {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1;
        }
        
        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .gallery-image:hover {
            transform: scale(1.05);
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover .image-overlay {
            opacity: 1;
        }
        
        .overlay-content {
            display: flex;
            gap: 10px;
        }
        
        .image-info {
            padding: 1rem;
            text-align: center;
        }
        
        .image-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="upload-card">
                        <div class="text-center mb-4">
                            <h2 class="title-gradient fw-bold">
                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                Upload Gambar
                            </h2>
                            <p class="text-muted">Pilih gambar yang ingin Anda upload</p>
                        </div>
                        
                        <form id="uploadForm" action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Upload Zone -->
                            <div class="upload-zone" id="uploadZone">
                                <div class="upload-icon">
                                    <i class="fas fa-image"></i>
                                </div>
                                <h5 class="mb-3">Drag & Drop gambar di sini</h5>
                                <p class="text-muted mb-3">atau</p>
                                <input type="file" 
                                       id="imageInput" 
                                       name="image" 
                                       accept="image/*" 
                                       style="display: none;">
                                <button type="button" 
                                        class="btn btn-custom" 
                                        onclick="document.getElementById('imageInput').click()">
                                    <i class="fas fa-folder-open me-2"></i>
                                    Pilih File
                                </button>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        Format yang didukung: JPG, PNG, GIF (Maksimal 5MB)
                                    </small>
                                </div>
                                
                                <!-- Loading Spinner -->
                                <div class="loading-spinner mt-3">
                                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                                    <p>Memproses gambar...</p>
                                </div>
                            </div>
                            
                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3 fade-in">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success mt-3 fade-in">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif
                        </form>
                        
                        <!-- Preview Container -->
                        <div id="previewContainer" class="preview-container" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-eye me-2 text-primary"></i>
                                    Preview Gambar
                                </h5>
                                <button type="button" 
                                        class="btn btn-danger-custom btn-sm" 
                                        id="removeImage">
                                    <i class="fas fa-trash me-1"></i>
                                    Hapus
                                </button>
                            </div>
                            
                            <div class="text-center">
                                <img id="previewImage" 
                                     src="" 
                                     alt="Preview" 
                                     class="preview-image">
                            </div>
                            
                            <!-- File Info -->
                            <div class="file-info">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Nama File:</strong>
                                        <span id="fileName" class="text-muted"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Ukuran:</strong>
                                        <span id="fileSize" class="text-muted"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Tipe:</strong>
                                        <span id="fileType" class="text-muted"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Upload Button -->
                            <div class="text-center mt-3">
                                <button type="submit" 
                                        form="uploadForm" 
                                        class="btn btn-custom btn-lg">
                                    <i class="fas fa-upload me-2"></i>
                                    Upload Gambar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gallery Section -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10 col-md-12">
                    <div class="upload-card">
                        <div class="text-center mb-4">
                            <h3 class="title-gradient fw-bold">
                                <i class="fas fa-images me-2"></i>
                                Galeri Gambar
                            </h3>
                            <p class="text-muted">Semua gambar yang telah diupload</p>
                        </div>
                        
                        @if($images && $images->count() > 0)
                            <div class="row g-4">
                                @foreach($images as $image)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="gallery-item">
                                            <div class="image-wrapper">
                                                <img src="" 
                                                     alt="{{ $image->name }}" 
                                                     class="gallery-image"
                                                     onclick="openImageModal('{{ $image->id }}', '', '{{ $image->name }}', '{{ number_format($image->size / 1024, 2) }}', '{{ $image->created_at->format('d M Y, H:i') }}')">
                                                <div class="image-overlay">
                                                    <div class="overlay-content">
                                                        <button class="btn btn-light btn-sm me-2" 
                                                                onclick="openImageModal('{{ $image->id }}', '', '{{ $image->name }}', '{{ number_format($image->size / 1024, 2) }}', '{{ $image->created_at->format('d M Y, H:i') }}')">
                                                            <i class="fas fa-search-plus"></i>
                                                        </button>
                                                        <form action="{{ route('image.delete', $image->id) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Yakin ingin menghapus gambar ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="image-info">
                                                <h6 class="image-title">{{ $image->name }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $image->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal for Image Preview - Removed individual modals -->
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            @if($images->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $images->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada gambar yang diupload</h5>
                                <p class="text-muted">Upload gambar pertama Anda menggunakan form di atas</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Universal Image Modal -->
    <div class="modal fade" id="universalImageModal" tabindex="-1" style="z-index: 9999;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImageTitle">Preview Gambar</h5>
                    <button type="button" class="btn-close" onclick="closeImageModal()"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid rounded" style="max-height: 70vh;">
                    <div class="mt-3" id="modalImageInfo">
                        <p class="mb-1"><strong>Nama:</strong> <span id="modalName"></span></p>
                        <p class="mb-1"><strong>Ukuran:</strong> <span id="modalSize"></span> KB</p>
                        <p class="mb-1"><strong>Diupload:</strong> <span id="modalDate"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="modalDownloadBtn" href="#" class="btn btn-custom" download="">
                        <i class="fas fa-download me-2"></i>
                        Download
                    </a>
                    <button type="button" class="btn btn-secondary" onclick="closeImageModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadZone = document.getElementById('uploadZone');
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const fileType = document.getElementById('fileType');
            const removeButton = document.getElementById('removeImage');
            const uploadForm = document.getElementById('uploadForm');
            const loadingSpinner = document.querySelector('.loading-spinner');
            
            // Drag and Drop handlers
            uploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadZone.classList.add('dragover');
            });
            
            uploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
            });
            
            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFileSelect(files[0]);
                }
            });
            
            // File input change handler
            imageInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    handleFileSelect(e.target.files[0]);
                }
            });
            
            // Handle file selection
            function handleFileSelect(file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file!');
                    return;
                }
                
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB!');
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    fileType.textContent = file.type;
                    
                    previewContainer.style.display = 'block';
                    previewContainer.classList.add('fade-in');
                };
                reader.readAsDataURL(file);
            }
            
            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            // Remove image
            removeButton.addEventListener('click', function() {
                imageInput.value = '';
                previewContainer.style.display = 'none';
                uploadZone.classList.remove('dragover');
            });
            
            // Form submission with loading state
            uploadForm.addEventListener('submit', function(e) {
                if (!imageInput.value) {
                    e.preventDefault();
                    alert('Silakan pilih gambar terlebih dahulu!');
                    return;
                }
                
                // Show loading state
                loadingSpinner.style.display = 'block';
                document.querySelector('.btn[type="submit"]').disabled = true;
            });
        });
        
        // Image Modal Functions
        function openImageModal(imageId, imageSrc, imageName, imageSize, imageDate) {
            const modal = document.getElementById('universalImageModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalImageTitle');
            const modalName = document.getElementById('modalName');
            const modalSize = document.getElementById('modalSize');
            const modalDate = document.getElementById('modalDate');
            const modalDownloadBtn = document.getElementById('modalDownloadBtn');
            
            // Set modal content
            modalImage.src = imageSrc;
            modalImage.alt = imageName;
            modalTitle.textContent = imageName;
            modalName.textContent = imageName;
            modalSize.textContent = imageSize;
            modalDate.textContent = imageDate;
            modalDownloadBtn.href = imageSrc;
            modalDownloadBtn.download = imageName;
            
            // Show modal
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
            
            // Add backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'modalBackdrop';
            backdrop.onclick = closeImageModal;
            document.body.appendChild(backdrop);
        }
        
        function closeImageModal() {
            const modal = document.getElementById('universalImageModal');
            const backdrop = document.getElementById('modalBackdrop');
            
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
            
            if (backdrop) {
                backdrop.remove();
            }
        }
        
        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</body>
</html>