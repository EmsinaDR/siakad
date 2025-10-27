@php
    //Catatan
    //Pilih aktiv-single
    //aktiv-multiple
    //else untuk create kelas
    use App\Models\Admin\Ekelas;
@endphp
@if ($slot == 'aktiv-single')
    {{-- = mode aktiv --}}
    @php
        $tingkata = Ekelas::select(['kelas'])
            ->where('aktiv', 'Y')
            ->where('tingkat_id', 7)
            ->get()
            ->toArray();
        $tingkata = collect($tingkata)->flatten(1);
        $tingkata = $tingkata->values()->all();
        $tingkatb = Ekelas::select(['kelas'])
            ->where('aktiv', 'Y')
            ->where('tingkat_id', 8)
            ->get()
            ->toArray();
        $tingkatb = collect($tingkatb)->flatten(1);
        $tingkatb = $tingkatb->values()->all();
        $tingkatc = Ekelas::select(['kelas'])
            ->where('aktiv', 'Y')
            ->where('tingkat_id', 9)
            ->get()
            ->toArray();
        $tingkatc = collect($tingkatc)->flatten(1);
        $tingkatc = $tingkatc->values()->all();
        // dd($tingkatc);
    @endphp
    <div class="row">
        <div id='tingkat' class="col-6">
            <!-- Dropdown Category -->
            <div class='form-group'>
                <label for="category">Tingkat</label>
                <select id="category" class='select2 form-control'>
                    <option value="">Pilih Tingkat</option>
                    <option value="VII">VII</option>
                    <option value="VIII">VIII</option>
                    <option value="IX">IX</option>
                </select>
            </div>
        </div>
        <div id='kelas' class="col-6">
            <div class='form-group'>

                <!-- Dropdown Subcategory -->
                <label for="subcategoryaktiv">Kelas</label>
                <select name='kelas_id' id="subcategoryaktiv" class='select2 form-control'>
                    {{-- <select class='menuselect3' name='kelas_id[]' multiple='multiple' id="subcategoryaktiv" data-placeholder='Pilih Kelas' style='width: 100%;'> --}}
                    <option value="">Pilih Kelas</option>
                </select>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Data untuk subkategori berdasarkan kategori
            var subcategories = {
                // fruits: ['Apple', 'Banana', 'Orange']
                VII: @json($tingkata),
                VIII: @json($tingkatb),
                IX: @json($tingkatc)
            };
            // Ketika kategori dipilih
            $('#category').change(function() {
                var categoryaktiv = $(this).val();
                var optionsaktiv = '<option value="">Pilih Kelas</option>';
                // Cek jika kategori yang dipilih ada dalam data subkategori
                if (category) {
                    var subcategoryListaktiv = subcategories[categoryaktiv];
                    subcategoryListaktiv.forEach(function(sub) {

                        optionsaktiv += `<option value="${sub}">${sub}</option>`;
                    });
                }
                // Set subcategory dropdown
                $('#subcategoryaktiv').html(optionsaktiv);
            });
        });
    </script>
@elseif($slot == 'aktiv-multiple')
    {{-- = mode aktiv --}}
    @php
        $tingkata = Ekelas::select(['kelas'])
            ->where('aktiv', 'Y')
            ->where('tingkat_id', 7)
            ->get()
            ->toArray();
        $tingkata = collect($tingkata)->flatten(1);
        $tingkata = $tingkata->values()->all();
        $tingkatb = Ekelas::select(['kelas'])
            ->where('aktiv', 'Y')
            ->where('tingkat_id', 8)
            ->get()
            ->toArray();
        $tingkatb = collect($tingkatb)->flatten(1);
        $tingkatb = $tingkatb->values()->all();
        $tingkatc = Ekelas::select(['kelas'])
            ->where('aktiv', 'Y')
            ->where('tingkat_id', 9)
            ->get()
            ->toArray();
        $tingkatc = collect($tingkatc)->flatten(1);
        $tingkatc = $tingkatc->values()->all();
        // dd($tingkatc);
    @endphp
    <div class="row">
        <div id='tingkat' class="col-md-6">
            <!-- Dropdown Category -->
            <div class='form-group'>
                <label for="category">Tingkat</label>
                <select id="category" class='select2 form-control'>
                    <option value="">Pilih Tingkat</option>
                    <option value="VII">VII</option>
                    <option value="VIII">VIII</option>
                    <option value="IX">IX</option>
                </select>
            </div>
        </div>
        <div id='kelas' class="col-md-6">

            <div class='form-group'>

                <!-- Dropdown Subcategory -->
                <label for="subcategoryaktiv">Kelas</label>
                {{-- <select name='kelas_id' id="subcategoryaktiv" class='form-control'> --}}
                <select class='menuselect3 select2 form-control' name='kelas_id[]' multiple='multiple'
                    id="subcategoryaktiv" data-placeholder='Pilih Kelas' style='width: 100%;'>
                    <option value="">Pilih Kelas</option>
                </select>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Data untuk subkategori berdasarkan kategori
            var subcategories = {
                // fruits: ['Apple', 'Banana', 'Orange']
                VII: @json($tingkata),
                VIII: @json($tingkatb),
                IX: @json($tingkatc)
            };
            // Ketika kategori dipilih
            $('#category').change(function() {
                var categoryaktiv = $(this).val();
                var optionsaktiv = '<option value="">Pilih Kelas</option>';
                // Cek jika kategori yang dipilih ada dalam data subkategori
                if (category) {
                    var subcategoryListaktiv = subcategories[categoryaktiv];
                    subcategoryListaktiv.forEach(function(sub) {

                        optionsaktiv += `<option value="${sub}">${sub}</option>`;
                    });
                }
                // Set subcategory dropdown
                $('#subcategoryaktiv').html(optionsaktiv);
            });
        });
    </script>
@else
    @php
        $alphabets = range('A', 'Z');
        $romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $dataslot = explode('/', $slot);
        for ($i = 0; $i < count($alphabets); $i++) {
            $kelasa[] = 'VII ' . $alphabets[$i];
        }
        for ($i = 0; $i < count($alphabets); $i++) {
            $kelasb[] = 'VIII ' . $alphabets[$i];
        }
        for ($i = 0; $i < count($alphabets); $i++) {
            $kelasc[] = 'IX ' . $alphabets[$i];
    } @endphp <br>
    <div class="row">
        <div id='kelas' class="col-6">
            <!-- Dropdown Category -->
            <div class='form-group'>
                <label for="ctingkat">Tingkat</label>
                <select name='tingkat_id' id="ctingkat" class='select2 form-control'>
                    <option value="">Pilih Tingkat</option>
                    <option value="7">VII</option>
                    <option value="8">VIII</option>
                    <option value="9">VIII</option>
                </select>
            </div>
        </div>
        <div id='kelas' class="col-6">
            <div class='form-group'>
                <!-- Dropdown Subcategory -->
                <label for="ckelas">Kelas</label>

                <select class='menuselect3 select2 form-control' name='kelas[]' multiple='multiple' id="ckelas"
                    data-placeholder='Pilih Kelas' style='width: 100%;'>
                    <option value="">Pilih Kelas</option>
                </select>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // Data untuk subkategori berdasarkan kategori
            var subcategories = {
                // fruits: ['Apple', 'Banana', 'Orange']
                7: @json($kelasa),
                8: @json($kelasb),
                9: @json($kelasc)

            };

            // Ketika kategori dipilih
            $('#ctingkat').change(function() {

                var ctingkat = $(this).val();
                var options = '<option value="">Select Kelas</option>';
                // Cek jika kategori yang dipilih ada dalam data subkategori
                if (ctingkat) {
                    var subcategoryList = subcategories[ctingkat];
                    subcategoryList.forEach(function(sub) {
                        options += `<option value="${sub}">${sub}</option>`;
                    });
                }
                // Set subcategory dropdown
                $('#ckelas').html(options);

            });
        });
    </script>
@endif
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#ckelas').select2()
    });
    $(function() {
        //Initialize Select2 Elements
        $('#subcategoryaktiv').select2()

    });
</script>
{{-- {{ $slot }} --}}
{{--
Catatan :
Gunakan isi slot dengan mode aktiv jika ingin mengambil data kelas yang aktif dan sudah di input
--}}
