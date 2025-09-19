@php
    // dd($slot);
    $datagrafik = explode('/', $slot);
    $label_grafik = explode(',', $datagrafik[0]); // Label
    $data_grafik = explode(',', $datagrafik[1]); // data
    $title_grafik = explode(',', $datagrafik[4]); // data
    $ukuran = explode(',', $datagrafik[3]); // data
    //$datagrafik[2] -> Type Grafik pie, bar, line
    //$datagrafik[3] -> Ukuran width n Height
    //$datagrafik[4] -> Title,Label
    // dd($data_grafik);
    //Data Pembayaran Siswa / 20,20,20 / VII A, VII B, VII C/pie

@endphp
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
{{-- <div style='width: 200px;'> --}}
<div style='width: 70%; margin: auto;'>
    <h3>{{$title_grafik[0]}}</h3>
    <canvas id='myChart' width='{{$ukuran[0]}}' height='{{$ukuran[1]}}'></canvas>
</div>
<script>
    const labels = @json($label_grafik);
    const data = @json($data_grafik);
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: '{{$datagrafik[2]}}', // Bisa juga 'doughnut'
        data: {
            labels: labels,
            datasets: [{
                label: '{{$title_grafik[1]}}',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
</script>
