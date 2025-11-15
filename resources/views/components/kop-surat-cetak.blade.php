    <style>
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            text-align: center;
            margin-bottom: 25px;
        }

        .logo {
            width: 150px;
            height: 150px;
        }

        .identitas {
            text-align: center;
        }

        h1 {
            font-size: 20px;
            margin: 0;
            margin-bottom: 10px;
        }

        .detail-skolah {
            font-size: 12pt;
        }

        .kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            text-align: center;
            margin-bottom: 25px;
            margin-top: 0;
        }

        .logo {
            width: 120px;
            /* Sedikit dikurangi agar lebih seimbang */
            height: 120px;
        }

        .identitas {
            text-align: center;
        }

        h2 {
            font-size: 20px;
            /* Ukuran utama lebih besar */
            margin: 0;
            font-weight: bold;
        }

        h3 {
            font-size: 18px;
            /* Ukuran subjudul lebih kecil */
            margin: 0;
            font-weight: bold;
        }

        p {
            font-size: 12pt;
            /* Ukuran detail tetap kecil */
            margin: 0;
        }

        #kop-title {
            font-size: 18px !important;
            /* Ukuran utama lebih besar */
            margin: 0;
            font-weight: bold;
        }

        .datasekolah {
            line-height: 1.5;
        }
    </style>
    @php
        // $Identitas = $Identitas = \App\Models\Admin\Identitas::first();
        $logoPath = public_path('img/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/jpeg;base64,' . $logoData;
    @endphp



    <table width="100%" style="margin-bottom: 16px; border: none;">
        <tr style="border: none;">
            <td width="20%" align="center" style="border: none;">
                <img src="{{ $logoSrc }}" alt="Logo" width="100">
            </td>
            <td class='datasekolah mt-1' width="80%" align="center" style="border: none;">
                <h2 id='kop-title' style="margin: 0;">{{ strtoupper($Identitas->jenjang) }}
                    {{ strtoupper($Identitas->nomor) }} {{ strtoupper($Identitas->namasek) }}</h2>
                <h3 style="margin: 0;">TERAKREDITASI {{ $Identitas->akreditasi }}</h3>
                <p style="margin: 0; font-size: 10px;"> Alamat : {{ $Identitas->alamat }}, Provinsi
                    {{ $Identitas->provinsi }} | Telepon: {{ $Identitas->phone }} | Email: {{ $Identitas->email }}
                </p>
            </td>
            <td width="20%" style="border: none;"></td> <!-- Kolom kosong untuk keseimbangan -->
        </tr>
    </table>

    <!-- Garis bawah -->
    <hr style="border: 3px solid black; margin-top: -8px; margin-bottom: 16px;">
