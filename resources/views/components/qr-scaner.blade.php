<style>
    .video-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    #previewKamera {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .scan-box {
        position: absolute;
        width: 200px;
        height: 200px;
        border: 3px dashed #28a745;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 10;
    }

    #id {
        width: 150px;
        text-align: center;
    }
</style>

{{-- <div class='card'> --}}
<div class="col ml-2  d-flex justify-content-center align-items-center">
    <div class="card mt-5 " style="width: 500px; height: 500px;align:center">
        <div class="video-container">
    <video id="previewKamera" autoplay></video>
    <div class="scan-box"></div> <!-- Ini kotaknya -->
</div>

        <div class="card border-0 mt-3">
            <form id='form' method='POST' action='{{ route('absensi.data-absensi-siswa.store') }}'>
                @csrf
                @method('POST')
                <div class="my-1  d-flex justify-content-center">
                    <input type='text' class='form-control'
                        id='id' name='datanis' placeholder='' autofocus> <br>
                        <select class='mx-auto' class='form-group' id='pilihKamera' style='max-width:400px' style="width: 500px; height: 500px;align:center"></select>
                    </div>



                <div class="my-2 d-flex justify-content-center "><button type='submit'
                        class='btn btn-primary btn-default bg-primary btn-lg'
                        onClick='document.location.reload(true)'>Refresh</button></div>
            </form>
        </div>

    </div>


</div>
    {{-- <video class='mx-auto ml-2' id='previewKamera' style='width: 350px;height: 400px'></video><br> --}}
    {{-- <video class=' mx-auto' id='previewKamera' style='width: 400px;height: 400px'></video><br> --}}


<script type='text/javascript' src='https://unpkg.com/@zxing/library@latest'></script>
<script src='https://code.jquery.com/jquery-3.5.1.min.js'
    integrity='sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=' crossorigin='anonymous'></script>
<script>
    //Submit dengan Enter
    $(document).on('keypress', 'form', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            alert('Data Berhasil Di Input');
            $(this).submit();
        }
    });
    //Akhir Submit dengan Enter
    let selectedDeviceId = null;
    const codeReader = new ZXing.BrowserMultiFormatReader();
    const sourceSelect = $('#pilihKamera');
    $(document).on('change', '#pilihKamera', function() {
        selectedDeviceId = $(this).val();
        if (codeReader) {
            codeReader.reset()
            initScanner()
        }
    })

    function initScanner() {
        codeReader
            .listVideoInputDevices()
            .then(videoInputDevices => {
                videoInputDevices.forEach(device =>
                    console.log(`${device.label}, ${device.deviceId}`)
                );
                if (videoInputDevices.length > 0) {
                    if (selectedDeviceId == null) {
                        if (videoInputDevices.length > 1) {
                            selectedDeviceId = videoInputDevices[1].deviceId
                        } else {
                            selectedDeviceId = videoInputDevices[0].deviceId
                        }
                    }
                    if (videoInputDevices.length >= 1) {
                        sourceSelect.html('');
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option')
                            sourceOption.text = element.label
                            sourceOption.value = element.deviceId
                            if (element.deviceId == selectedDeviceId) {
                                sourceOption.selected = 'selected';
                            }
                            sourceSelect.append(sourceOption)
                        })
                    }
                    codeReader
                        .decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                        .then(result => {
                            //hasil scan ke dalam log cosole inspect
                            console.log(result.text)
                            //ID tempat hasil atau dimana akan ditampilkan  ke dalam input area
                            $('#id').val(result.text);
                            //Skema begitu id ketemu akan di form submit langsung
                            $(form).submit();
                            $(document).on('keypress', form, function(event) {
                                if (event.keyCode === 13) {
                                    event.preventDefault();
                                    alert('Data Berhasil Di Input :' + result.text);
                                    $(form).submit();
                                }
                            })
                            $(document).on(form, function(load) {
                                load.preventDefault();
                                $(form).submit();
                                //alert('Data Berhasil Di Input :'+ result.text);
                                //$(form).submit();
                            });
                            if (codeReader) {
                                codeReader.reset()
                            }
                        })
                        .catch(err => console.error(err));
                } else {
                    alert('Camera not found!')
                }
            })
            .catch(err => console.error(err));
    }
    if (navigator.mediaDevices) {
        initScanner()
    } else {
        alert('Cannot access camera.');
    }
</script>
