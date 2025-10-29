@php
    use App\Models\Learning\Emateri;
    use App\Models\Admin\Etapel;
    // use Illuminate\Http\Request;

    $datadropdown = explode('/', $slot);
    $etapel = Etapel::where('aktiv', 'Y')->first();
    $ematerispokoks = Emateri::select('materi')
        ->where('mapel_id', $datadropdown[0])
        ->where('semester', $etapel->semester)
        ->where('tingkat_id', $datadropdown[1])
        ->distinct('materi')
        ->get();
    // dd($ematerispokoks);
    // dd($datadropdown[0]);
    $mapel_id = $datadropdown[0];
    // dd($ematerispokoks);
    // json_encode($ematerispokoks)
@endphp

<form>
    <div class='form-group col-12'>
        <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
        <label for="materi">Materi Pokok:</label>
        <select id='materi_edit-{{ $datadropdown[2] }}' class='form-control' name='materi' data-placeholder='Materi'
            style='width: 100%;' required>
            <option value="">Pilih Materi Pokok</option>
            @foreach ($ematerispokoks as $materi)
                <option value='{{ $materi->materi }}'>{{ $materi->materi }}</option>
            @endforeach

        </select>
    </div>

    <div class='form-group col-12'>
        <label for="sub_materi">Sub Materi:</label>
        <select id='sub_materi_edit-{{ $datadropdown[2] }}' name='sub_materi' class='form-control'
            data-placeholder='Sub Materi' style='width: 100%;' disabled required>
            <option value="">Pilih Sub Materi</option>
        </select>
    </div>

    <div class='form-group col-12'>
        <label for="indikator">Indikator:</label>
        <select id='indikator_edit_{{ $datadropdown[2] }}' name='indikator_id[]' class='form-control'
            multiple='multiple' data-placeholder='Indikator Materi' style='width: 100%;' disabled required>
            <option value="">Pilih Indikator</option>
        </select>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#materi_edit-{{ $datadropdown[2] }}').change(function() {
            let materi_id = $(this).val();

            $.ajax({
                type: 'GET',
                url: `{{ app('request')->root() }}/api-emateri-mapel-to-materi/` +
                    @json($datadropdown[0]) + `/${materi_id}`,
                success: function(data) {
                    console.log(data);
                    data.forEach(data => {
                        // $('#remove_sub-{{ $datadropdown[2] }}').remove();

                        $('#sub_materi_edit-{{ $datadropdown[2] }}').append(
                            `<option id="remove_sub-{{ $datadropdown[2] }}" value="${data.sub_materi}">${data.sub_materi}</option>`
                            );

                    });
                    $('#sub_materi_edit-{{ $datadropdown[2] }}').prop('disabled', false);

                }
            })
            $('#sub_materi_edit-{{ $datadropdown[2] }}').change(function() {
                let sub_materi = $(this).val();
                // alert(sub_materi)
                // alert('oke')
                $('#indikator_edit_{{ $datadropdown[2] }} option').remove();
                $.ajax({
                    type: 'GET'
                        ///api-emateri-sub-to-indikator/{materi}/{sub_materi}

                        ,
                    url: `{{ app('request')->root() }}/api-emateri-sub-to-indikator/${materi_id}/${sub_materi}`

                        ,
                    success: function(data) {
                        console.log(data);
                        data.forEach(data => {
                            $('#indikator_edit_{{ $datadropdown[2] }}')
                                .append(
                                    `<option value="${data.id}">${data.indikator}</option>`
                                    );
                        });
                        $('#indikator_edit_{{ $datadropdown[2] }}').prop(
                            'disabled', false);

                    }
                })
            })

        })

    });
</script>
