<style>
    .signature-wrapper {
        font-family: Arial, sans-serif;
        margin-top: 50px;
    }

    .signature-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        border: none;
    }

    .signature-table td {
        text-align: center;
        padding: 20px;
        vertical-align: top;
        border: none;
    }

    .signature-wrapper {
        font-size: 12px;
        margin-top: 10px;
    }

    .nip {
        margin-left: -145px;
    }

    .signature-wrapper u {
        display: inline-block;
        margin-top: 60px;
        text-decoration: underline;
    }
</style>
@if (count($ttds) === 1)
    <div class="signature-wrapper">
        <table class="signature-table">
            <tr>
                <td width="50%">
                    <!-- Kosong jika hanya satu tanda tangan -->
                </td>
                <td>
                    {{ $tempat ?? 'Banjarharjo' }}, {{ $tanggal ?? '2 September 2025' }} <br>
                    <strong>{{ $ttds[0]['jabatan'] ?? 'Kepala Sekolah' }}</strong><br><br><br>
                    <u>( {{ $ttds[0]['nama'] ?? 'Farid Attalah' }} )</u><br>
                    <p class="nip">NIP. {{ $ttds[0]['nip'] ?? '-' }}</p>
                </td>
            </tr>
        </table>
    </div>
@else
    <div class="signature-wrapper">
        <table class="signature-table">
            <tr>
                <td width="50%">
                    <strong>{{ $ttds[0]['jabatan'] }}</strong><br><br><br>
                    <u>( {{ $ttds[0]['nama'] ?? 'Dany Rosepta, S.Pd' }} )</u><br>
                    <span class="nip">NIP. {{ $ttds[0]['nip'] ?? '28021989' }}</span>
                </td>
                <td>
                    {{ $tempat ?? 'Banjarharjo' }}, {{ $tanggal ?? '2 September 2025' }} <br>
                    <strong>{{ $ttds[1]['jabatan'] ?? 'Kepala Sekolah' }}</strong><br><br><br>
                    <u>( {{ $ttds[1]['nama'] ?? 'Farid Attalah, S.Pd' }} )</u><br>
                    <span class="nip">NIP. {{ $ttds[1]['nip'] ?? '-' }}</span>
                </td>
            </tr>
        </table>
    </div>
@endif
