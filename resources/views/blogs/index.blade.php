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
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            <h2>blogs List</h2>
            <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Create blogs</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>title</th>
                        <th>content</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->content }}</td>
                            <td>
                                <a href="{{ route('blogs.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('blogs.destroy', $item->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                    order: [
                        [3, 'desc']
                    ] // Sort by date
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
