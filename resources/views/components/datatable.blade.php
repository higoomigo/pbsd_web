@props([
  'id' => 'datatable',
  'order' => '[5,"asc"]',
  'pageLength' => 10,
  'lengthMenu' => '[10,25,50,100]',
  'buttons' => true,
  'responsive' => true,
])

@once
  @push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.min.css">

    <style>
      /* Base: force light look */
      .dt-reset { background:#fff !important; color:#0a0a0a !important; }
      .dt-reset * { color:#0a0a0a !important; }

      /* Cells (jangan sentuh TH di sini) */
      .dt-reset table,
      .dt-reset table td {
        background:#fff !important; color:#0a0a0a !important;
      }

      /* Links inside table */
      .dt-reset a { color:#0a0a0a !important; }
      .dt-reset a:hover { color:#111827 !important; text-decoration: underline; }

      /* Top controls: length + filter */
      .dt-reset .dataTables_length label,
      .dt-reset .dataTables_filter label { color:#0a0a0a !important; }
      .dt-reset .dataTables_length select,
      .dt-reset .dataTables_filter input {
        background:#fff !important; color:#0a0a0a !important; border:1px solid #e5e7eb !important; /* zinc-200 */
      }

      /* Bottom controls: info + paginate */
      .dt-reset .dataTables_info { color:#0a0a0a !important; }
      .dt-reset .dataTables_paginate a,
      .dt-reset .dataTables_paginate span a { color:#0a0a0a !important; }
      .dt-reset .dataTables_paginate .current,
      .dt-reset .dataTables_paginate .current:hover {
        background:#e5e7eb !important; color:#0a0a0a !important; border-color:#d1d5db !important;
      }

      /* Buttons export */
      .dt-reset .dt-buttons .dt-button {
        background:#f3f4f6 !important; /* zinc-100 */
        color:#0a0a0a !important; border:1px solid #e5e7eb !important;
      }
      .dt-reset .dt-buttons .dt-button:hover { background:#e5e7eb !important; }

      /* Row hover */
      .dt-reset table.dataTable.hover tbody tr:hover,
      .dt-reset table.dataTable.display tbody tr:hover {
        background:#f9fafb !important; /* zinc-50 */
      }

      /* === HEADER TH (DARK) === */
      .dt-reset thead th {
        background:#111827 !important;   /* zinc-900 */
        color:#ffffff !important;         /* white text */
        border-bottom:1px solid #1f2937 !important; /* zinc-800 */
      }
      .dt-reset thead th.sorting,
      .dt-reset thead th.sorting_asc,
      .dt-reset thead th.sorting_desc {
        background:#111827 !important;
        color:#ffffff !important;
      }
    </style>
  @endpush

  @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  @endpush
@endonce

<div class="dt-reset overflow-x-auto">
  <table id="{{ $id }}" class="display nowrap w-full text-sm">
    {{ $slot }}
  </table>
</div>

@push('scripts')
<script>
  $(function(){
    const table = $('#{{ $id }}').DataTable({
      responsive: {{ $responsive ? 'true' : 'false' }},
      pageLength: {{ $pageLength }},
      lengthMenu: {!! $lengthMenu !!},
      order: [{!! $order !!}],
      language: { url: 'https://cdn.datatables.net/plug-ins/2.1.6/i18n/id.json' },
      dom: {!! $buttons ? "'Bfrtip'" : "'frtip'" !!},
      buttons: {!! $buttons ? "[{ extend:'excelHtml5', title: document.title || 'Data' },{ extend:'pdfHtml5', title: document.title || 'Data', orientation:'portrait', pageSize:'A4' },{ extend:'print', title: document.title || 'Data' }]" : '[]' !!}
    });

    document.addEventListener('datatable:recalc', () => table.columns.adjust().responsive.recalc());
  });
</script>
@endpush
