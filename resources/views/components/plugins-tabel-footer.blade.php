{{-- Plugins Tabel Footer --}}
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
$(document).ready(function() {
    const tables1 = 250;
    const tables2 = 50;

    // Loop #example0 - #example250
    for (let i = 0; i <= tables1; i++) {
        let tableId = `#example${i}`;
        if ($(tableId).length) {
            new DataTable(tableId, {
                responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: row => {
                                let data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({ tableClass: 'table' })
                    }
                },
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true
            });
        }
    }

    // Loop #example-intd-0 - #example-intd-250
    for (let i = 0; i <= tables1; i++) {
        let tableId = `#example-intd-${i}`;
        if ($(tableId).length) {
            new DataTable(tableId, {
                responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: row => 'Details for ' + row.data()[0] + ' ' + row.data()[1]
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({ tableClass: 'table' })
                    }
                }
            });
        }
    }

    // Loop #table-index1 - #table-index250
    for (let i = 1; i <= tables1; i++) {
        let tableId = `#table-index${i}`;
        if ($(tableId).length) {
            new DataTable(tableId, {
                responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: row => 'Details for ' + row.data()[0] + ' ' + row.data()[1]
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({ tableClass: 'table' })
                    }
                }
            });
        }
    }

    // Loop #tableloop1 - #tableloop50
    for (let i = 1; i <= tables2; i++) {
        let tableId = `#tableloop${i}`;
        if ($(tableId).length) {
            new DataTable(tableId, {
                responsive: {
                    details: {
                        display: DataTable.Responsive.display.modal({
                            header: row => 'Details for ' + row.data()[0] + ' ' + row.data()[1]
                        }),
                        renderer: DataTable.Responsive.renderer.tableAll({ tableClass: 'table' })
                    }
                }
            });
        }
    }

    // Table khusus #exampletabel
    if ($('#exampletabel').length) {
        new DataTable('#exampletabel', {
            responsive: {
                details: {
                    display: DataTable.Responsive.display.modal({
                        header: row => 'Details for ' + row.data()[0] + ' ' + row.data()[1]
                    }),
                    renderer: DataTable.Responsive.renderer.tableAll({ tableClass: 'table' })
                }
            }
        });
    }
});
</script>
{{-- Plugins Tabel Footer --}}
