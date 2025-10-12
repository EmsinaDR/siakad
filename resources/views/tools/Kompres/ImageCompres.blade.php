<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

<style>
    .drop-zone {
        width: 100%;
        height: 180px;
        border: 2px dashed #aaa;
        border-radius: 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }

    .drop-zone.active {
        border-color: green;
        background-color: #e6ffe6;
    }

    .gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 5px;
    }

    .image-box {
        width: calc(20% - 10px);
        box-sizing: border-box;
        text-align: center;
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2px;
        border-radius: 6px;
    }

    .image-box input[type="checkbox"] {
        display: none;
    }

    .image-box img {
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: 0.2s;
    }

    .image-box input[type="checkbox"]:checked + img {
        border-color: red;
        opacity: 0.7;
    }

    .download-btn {
        margin-top: 5px;
        background-color: #28a745;
        color: white;
        padding: 4px 10px;
        font-size: 13px;
        border-radius: 5px;
        text-decoration: none;
        width: auto;
        text-align: center;
    }

    .download-btn:hover {
        background-color: #1f7a35;
    }

    .image-thumbnail {
        width: 100%;
        height: auto;
        border-radius: 8px;
        display: block;
        object-fit: cover;
        margin-bottom: 6px;
    }

    .image-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .download-btn {
        margin-top: 8px;
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .download-btn:hover {
        background-color: #218838;
    }

    /* New CSS for slider */
    .slider-container {
        margin-top: 10px;
        width: 100%;
        text-align: center;
    }

    .slider {
        width: 80%;
        margin: 0 auto;
    }

    .slider-label {
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<section class="content mx-2 my-4">
    <div class="card">
        <div class="card-header bg-primary mx-2">
            <h3 class="card-title text-white">{{ $title }}</h3>
        </div>
        <div class="card-body">

            {{-- Upload --}}
            <form action="{{ route('image.compress') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <input type="file" name="images[]" id="image" class="d-none" multiple accept="image/*">
                <div class="drop-zone" id="drop-zone">
                    <p>Drag & Drop Images or Click to Select</p>
                </div>
                <div class="gallery" id="preview-gallery"></div>

                {{-- Slider for resizing --}}
                <div class="slider-container">
                    <label for="image-size" class="slider-label">Adjust Image Size:</label>
                    <input type="range" id="image-size" class="slider" min="50" max="100" value="100">
                    <span id="slider-value">100%</span>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Upload & Compress</button>
            </form>

            {{-- Download & Delete --}}
            @if(isset($images) && count($images))
                <form action="{{ route('image.delete.selected') }}" method="POST" id="delete-form">
                    @csrf

                    <div class="d-flex justify-content-end my-3">
                        <a href="{{ route('image.download.all') }}" class="btn btn-success me-2">Download All</a>
                        <button type="submit" class="btn btn-danger" id="delete-btn">Delete Selected</button>
                    </div>

                    <div class="gallery">
                        @foreach ($images as $image)
                            <div class="image-box">
                                <label>
                                    <input type="checkbox" name="delete_ids[]" value="{{ $image['id'] }}">
                                    <img src="{{ asset($image['path']) }}" alt="Image">
                                </label>
                                <a href="{{ route('image.download', $image['id']) }}" class="download-btn">Download</a>
                            </div>
                        @endforeach
                    </div>
                </form>
            @endif
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const dropZone = document.getElementById('drop-zone');
    const imageInput = document.getElementById('image');
    const previewGallery = document.getElementById('preview-gallery');
    const imageSizeSlider = document.getElementById('image-size');
    const sliderValue = document.getElementById('slider-value');

    dropZone.addEventListener('click', () => imageInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('active');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('active');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('active');
        const files = e.dataTransfer.files;
        imageInput.files = files;
        showPreview(files);
    });

    imageInput.addEventListener('change', function () {
        showPreview(this.files);
    });

    imageSizeSlider.addEventListener('input', function () {
        sliderValue.textContent = `${this.value}%`;
        updateImageSize(this.value);
    });

    function showPreview(files) {
        previewGallery.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            if (!files[i].type.startsWith('image/')) continue;
            const reader = new FileReader();
            reader.onload = function (e) {
                const div = document.createElement('div');
                div.classList.add('image-box');
                div.innerHTML = `
                    <label>
                        <input type="checkbox" checked>
                        <img src="${e.target.result}" class="preview-img">
                    </label>
                `;
                previewGallery.appendChild(div);
            }
            reader.readAsDataURL(files[i]);
        }
    }

    function updateImageSize(size) {
        const images = document.querySelectorAll('.preview-img');
        images.forEach(image => {
            image.style.width = `${size}%`;
        });
    }

    document.getElementById('delete-btn')?.addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin Hapus?',
            text: "Gambar terpilih akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    });
</script>
</x-layout>
