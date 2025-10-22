{{-- <x-dropdown-allsiswa type='multiple' :listdata='$listdata' label='Data Siswa X' name='detailsiswa_id' id_property='id_single' /> --}}

@if ($type === 'single')
    <div class="form-group">
    <i class="fa fa-user mr-2"></i><label for="id_{{$id_property}}">{{$label}}</label>
        <select id="single-{{$id_property}}" name="detailsiswa_id" class="form-control" required>
            <option value="">--- Pilih {{$label}} ---</option>
            @foreach ($listdata as $newkey)
                <option value="{{ $newkey->id }}">{{ $newkey->nama_siswa }} - {{ $newkey->kelas->kelas }}</option>
            @endforeach
        </select>
    </div>
@elseif ($type === 'multiple')
    <i class="fa fa-user mr-2"></i><label for="id_{{$id_property}}">{{$label}}</label>
    <select id="id_{{$id_property}}" class="select2" name="{{$name}}[]" multiple="multiple" data-placeholder="Data Siswa" style="width: 100%;">
        <option value="">--- Pilih {{$label}} ---</option>
        @foreach ($listdata as $newkey)
            <option value="{{ $newkey->id }}">{{ $newkey->Detailsiswatokelas->kelas }} - {{ $newkey->nama_siswa }}</option>
        @endforeach
    </select>
@else
    <p>Jenis dropdown tidak valid!</p>
@endif
