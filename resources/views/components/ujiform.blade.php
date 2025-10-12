<form id='#id' action='ekelas/8' method='POST'>
    @csrf
    @method('PATCH')
    <div class='form-group'>
        <label for='id'>nam_label</label>
        <input type='text' class='form-control' id='id' name='id' placeholder='' value='8' required>
    </div>
    <div class='form-group'>
        <label for='dataguru_id'>Guru</label>
        <input type='text' class='form-control' id='dataguru_id' name='dataguru_id' placeholder='' value='3' required>
    </div>
    <button type='submit' class='btn bg-primary btn-block btn-sm'><i class='fa fa-bullhorn text-center'></i> Kirim</button>
</form>
