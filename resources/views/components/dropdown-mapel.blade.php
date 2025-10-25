 @php
     use App\Models\Admin\Emapel;
     $mapels = App\Models\Admin\Emapel::all();
 @endphp
 {{-- slot berisi id --}}
 <div class='form-group'>
     <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
     <label>Mapel Aktif</label>
     <select id='{{ $slot }}' class='select2' name='mapel_id[]' multiple='multiple[]'
         data-placeholder='Pilih Mapel Aktiv' style='width: 100%;'>

         <option value=''>Pilih Mata Pelajaran</option>
         @foreach ($mapels as $mapel)
             <option value='{{ $mapel['id'] }}'>{{ $mapel['mapel'] }}</option>
         @endforeach
     </select>
 </div>
 <script>
     $(function() {
         //Initialize Select2 Elements
         $('#{{ $slot }}').select2()
     });
 </script>
