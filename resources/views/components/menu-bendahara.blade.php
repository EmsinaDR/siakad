
@if ($namaProgram === 'Bedahara Komite')
    <x-menu-bendahara-komite></x-menu-bendahara-komite>
@elseif ($namaProgram === 'Bendahara Tabungan')
    <x-menu-bendahara-tabungan></x-menu-bendahara-tabungan>
@elseif ($namaProgram === 'Bendahara BOS')
    <x-menu-bendahara-bos></x-menu-bendahara-bos>
@elseif ($namaProgram === 'Bendahara Komite')
    <x-menu-bendahara-komite></x-menu-bendahara-komite>
@elseif ($namaProgram === 'Bendahara PIP')
    <x-menu-bendahara-pip :nama-program="$namaProgram" />
@elseif ($namaProgram === 'Bendahara CSR')
    <x-menu-bendahara-csr :nama-program="$namaProgram" />
@elseif ($namaProgram === 'Bendahara Study Tour')
    <x-menu-bendahara-study-tour></x-menu-bendahara-study-tour>
@else
@endif
