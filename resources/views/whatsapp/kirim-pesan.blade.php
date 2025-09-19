<x-layout>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/FNnamaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                <div class="col-xl-12 my-4 my-2">
                    <div class='card-header bg-warning'>
                        <h3 class='card-title'>Send WhatsApp Message</h3>
                    </div>
                    <input type="text" id="session_id" value='{{ $sessions }}' placeholder="Session ID">
                    <div class='form-group'>
                        <label for='number'>Nomor HP Tujuan</label>
                        <input type='text' class='form-control' id='number' name='number' value='6285329860005'
                            placeholder='Nomor HP Tujuan' required>
                    </div>
                    <div class='form-group'>
                        <label for='message'></label>
                        <textarea type='text' class='form-control' id='message' name='message' placeholder='' required>sayang</textarea>
                    </div>
                    <button onclick="sendMessage()">Send Message</button>

                    <script>
                        function sendMessage() {
                            let sessionId = document.getElementById("session_id").value;
                            let number = document.getElementById("number").value;
                            let message = document.getElementById("message").value;

                            fetch("http://localhost:3000/send-message", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    id: sessionId,
                                    number: number,
                                    message: message
                                })
                            }).then(response => response.json()).then(data => {
                                alert(data.message);
                            });
                        }
                    </script>
                </div>
                <div class="col-xl-12 my-4">
                    <div class='card-header bg-primary my-2'>
                        <h3 class='card-title'>Send File via WhatsApp</h3>
                    </div>
                    <div class='form-group'>
                        <label for='number'>Nomor HP Tujuan</label>
                        <input type='text' class='form-control' id='number' name='number' value='6285329860005'
                            placeholder='Nomor HP Tujuan' required>
                    </div>
                    <input type="text" id="session_id" value='{{ $sessions }}' placeholder="Session ID">
                    {{-- <input type="text" id="number" value='6285329860005' placeholder="Recipient Number (ex: 62812345678)"> --}}
                    <div class='form-group'>
                        <label for='number'>File</label>
                        <input type="file" id="fileInput-nocaption">
                    </div>
                    <button onclick="sendFileNoCaption()">Send File</button>

                    <script>
                        function sendFileNoCaption() {
                            let sessionId = document.getElementById("session_id").value;
                            let number = document.getElementById("number").value;
                            let fileInput = document.getElementById("fileInput-nocaption").files[0];

                            if (!sessionId || !number || !fileInput) {
                                alert("Please fill all fields and select a file!");
                                return;
                            }

                            let formData = new FormData();
                            formData.append("id", sessionId);
                            formData.append("number", number);
                            formData.append("file", fileInput);

                            fetch("http://localhost:3000/send-file", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message);
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    alert("Failed to send file!");
                                });
                        }
                    </script>
                </div>


                <div class="col-xl-12 my-4">
                    <div class='card-header bg-success my-2'>
                        <h3 class='card-title'>
                            Send File with Caption via WhatsApp</h3>
                    </div>
                    <input type="text" value='{{ $sessions }}' placeholder="Session ID">
                    <div class='form-group'>
                        <label for='number'>Nomor HP Tujuan</label>
                        <input type='text' class='form-control' id='number' name='number' value='6285329860005'
                            placeholder='Nomor HP Tujuan' required>
                    </div>

                    <div class='form-group'>
                        <label for='caption'>Caption</label>
                        <input type='text' class='form-control' id='caption' name='caption' value='sayang'
                            required>
                    </div>

                    <input type="file" id="fileInput-caption">
                    <button onclick="sendFile()">Send File</button>

                    <script>
                        function sendFile() {
                            let sessionId = document.getElementById("session_id").value;
                            let number = document.getElementById("number").value;
                            let fileInput = document.getElementById("fileInput-caption").files[0];
                            let caption = document.getElementById("caption").value;

                            if (!sessionId || !number || !fileInput) {
                                alert("Please fill all fields and select a file!");
                                return;
                            }

                            let formData = new FormData();
                            formData.append("id", sessionId);
                            formData.append("number", number);
                            formData.append("file", fileInput);
                            formData.append("caption", caption);

                            fetch("http://localhost:3000/send-file-caption", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message);
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    alert("Failed to send file!");
                                });
                        }
                    </script>
                </div>
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function FNnamaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
                <input type="text" id="session_id" placeholder="Enter your session ID">
                <button onclick="startSession()">Start Session</button>
                <br><br>
                <img id="qr_code" style="width: 300px; display: none;">
                <h3 id="status"></h3>

                <script>
                    const socket = io("http://localhost:3000", {
                        transports: ["websocket", "polling"]
                    });


                    function startSession() {
                        let sessionId = document.getElementById("session_id").value;
                        fetch("http://localhost:3000/start-session", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                id: sessionId
                            })
                        });

                        socket.on(`qr-${sessionId}`, (qr) => {
                            document.getElementById("qr_code").src = qr;
                            document.getElementById("qr_code").style.display = "block";
                        });

                        socket.on(`ready-${sessionId}`, (msg) => {
                            document.getElementById("status").innerText = msg;
                            document.getElementById("qr_code").style.display = "none";
                        });
                    }
                </script>


            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
