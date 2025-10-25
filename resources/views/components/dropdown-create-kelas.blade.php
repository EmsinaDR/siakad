@php
use App\Models\Admin\Ekelas;
$alphabets = range('A', 'Z');
$romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
$dataslot = explode('/', $slot);
for($i=0; $i < count($alphabets); $i++){ $kelasa[]='VII ' .$alphabets[$i]; } for($i=0; $i < count($alphabets); $i++){ $kelasb[]='VIII ' .$alphabets[$i]; } for($i=0; $i < count($alphabets); $i++){ $kelasc[]='IX ' .$alphabets[$i]; } @endphp <div class="row ">

    <div id='kelas' class="{{ $dataslot[0] }}">

        <!-- Dropdown Category -->
        <div class='form-group'>

            <label for="category">Tingkat</label>

            <select name='tingkat_id' id="category_created" class='select2 form-control'>
                <option value="">Pilih Tingkat</option>

                <option value="7">VII</option>
                <option value="8">VIII</option>
                <option value="9">IX</option>
            </select>
        </div>
    </div>


    <div id='kelas' class="{{ $dataslot[0] }}">

        <div class='form-group'>
            <!-- Dropdown Subcategory -->
            <label for="kelas_created">Kelas</label>

            <select class='select2 menuselect5' name='kelas_created[]' multiple='multiple' id="kelas_created" data-placeholder='Masukkan Kelas' style='width: 100%;'>

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
                7: @json($kelasa)
                , 8: @json($kelasb)
                , 9: @json($kelasc)
            };

            // Ketika kategori dipilih
            $('#category_created').change(function() {

                var category_created = $(this).val();

                var options = '<option value="">Select Subcategory</option>';

                // Cek jika kategori yang dipilih ada dalam data subkategori
                if (category_created) {

                    var subcategoryList = subcategories[category_created];

                    subcategoryList.forEach(function(sub) {
                        options += `<option value="${sub}">${sub}</option>`;
                    });
                }

                // Set subcategory dropdown
                $('#kelas_created').html(options);

            });
        });

    </script>
