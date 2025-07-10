@push('scripts')
    <script>
        $('#tablaUsuarios').DataTable({
            dom: '<"flex justify-between items-center mb-4"l f> <"flex justify-start mb-2"B> rt <"bottom"ip><"clear">',
            buttons: [
                'copy', 'excel', 'pdf', 'csv'
            ],
            language: {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron resultados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "buttons": {
                    "copy": "Copiar",
                    "excel": "Excel",
                    "pdf": "PDF",
                    "csv": "CSV",
                    "print": "Imprimir"
                }
            }
        });
    </script>
@endpush
