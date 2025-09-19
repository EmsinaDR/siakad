@php
    $Identitas = \App\Models\Admin\Identitas::first();
@endphp
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .kop-surat {
        width: 100%;
        border-bottom: 3px solid #000;
        /* padding: 10px 0; */
        text-align: center;
        margin-bottom: 25px;
    }

    .logo {
        float: left;
        width: 45%;
        height: 50%;
        margin-right: \ApAppp\Models\Admin\Identitas;
    }

    .identitas {
        text-align: center;
        display: inline-block;
    }

    h1 {
        font-size: 20px;
        margin: 0;
        padding: 0;
        margin-bottom: 15px;
    }

    .detail-skolah {
        margin: 5px 0;
        font-size: 10px;
    }
</style>
<div class="kop-surat">

    <div class="row">
        <div class="col-xl-3 d-flex justify-content-center align-items-center">
            <img class='rounded' src="{{ asset('img/logo.png') }}" alt="Logo Sekolah" class="logo"
                style='width:150px;height:150px'>
        </div>
        <div class="col-xl-8 d-flex justify-content-center align-items-center">
            <div class="identitas">
                <h1 style="margin: 0;"><b>{{ Str::upper($Identitas->namasek) }}</b></h1>
                <h3 style="margin: 0;">TERAKREDITASI {{ Str::upper($Identitas->akreditasi) }}</h3>
                <p style="margin: 0; font-size: 10px;"> Alamat : {{ $Identitas->alamat }}, Provinsi
                    {{ $Identitas->provinsi }} | Telepon: {{ $Identitas->phone }} | Email: {{ $Identitas->email }}
                </p>
            </div>
        </div>
        <div class="col-xl-1"></div>
    </div>
</div>
