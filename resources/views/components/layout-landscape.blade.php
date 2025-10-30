<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Landscape</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS Print --}}
    <style>
        @media print {

            html,
            body {
                width: 33cm;
                height: 21cm;
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            @page {
                size: landscape;
                margin-top: 1cm;
            }

            .container,
            .container-fluid,
            .row,
            .col {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            table.table-sm {
                font-size: 10px !important;
            }

            .table-sm td,
            .table-sm th {
                padding: 0.2rem 0.3rem !important;
                font-size: 10px !important;
                /* text-align: left !important; */
                vertical-align: middle !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-left,
            .text-start {
                text-align: left !important;
            }

            .text-right,
            .text-end {
                text-align: right !important;
            }

            .align-middle {
                vertical-align: middle !important;
            }

            .page-break {
                page-break-before: always;
                break-before: page;
            }

            .info-header {
                display: flex !important;
                flex-wrap: nowrap !important;
                margin-bottom: 0.5rem;
                gap: 0;
            }

            .info-header>div {
                flex: 1 1 0;
                max-width: 33.33%;
                padding-left: 5px;
                padding-right: 5px;
            }
            .col-print-3 {
            width: 30% !important;
            float: left !important;
        }
        .card {
            page-break-inside: avoid;
        }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 1rem;
        }
    </style>
</head>

<body>
    {{ $slot }}
</body>

</html>
