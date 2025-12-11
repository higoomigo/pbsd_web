{{-- resources/views/components/datatable.blade.php --}}
@props([
  'id'          => 'datatable',
  'order'       => '[0,"asc"]',
  'pageLength'  => 10,
  'lengthMenu'  => '[10,25,50,100]',
  'buttons'     => true,
])

@once
  @push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.min.css">

    <style>
      .dtflat {
        background:#fff;
        color: #1f2937;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      }

      .dtflat table{
        background:#fff !important;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
      }

      /* Header dengan rounded corners */
      .dtflat thead th{
        background:#41454e !important;
        color:#fff !important;
        font-weight:700;
        /* border-bottom:1px solid #1f2937 !important; */
        padding: 0.75rem 1rem;
      }

      .dtflat thead th:first-child {
        border-top-left-radius: 0.5rem;
      }

      .dtflat thead th:last-child {
        border-top-right-radius: 0.5rem;
      }

      /* Body cells */
      .dtflat tbody td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
      }

      /* Hover row */
      .dtflat table.dataTable.hover tbody tr:hover{
        background:#f9fafb !important;
      }

      /* Layout controls */
      .dt-container .dt-layout-row{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:.75rem;
        flex-wrap:wrap;
        margin-bottom:.5rem;
      }

      .dt-container .dt-layout-row .dt-length select,
      .dt-container .dt-layout-row .dt-search input{
        background:#fff;
        color:#0a0a0a;
        border:1px solid #e5e7eb;
        border-radius:.5rem;
        padding:.4rem .6rem;
      }

      /* Buttons */
      .dt-container .dt-buttons{
        display:flex;
        gap:.5rem;
      }
      .dt-container .dt-button{
        display:inline-flex;
        align-items:center;
        gap:.5rem;
        background:#111827 !important;
        color:#fff !important;
        border:1px solid #111827 !important;
        border-radius:.5rem !important;
        padding:.45rem .8rem !important;
        line-height:1 !important;
        font-weight:600 !important;
        box-shadow: 0 1px 2px rgba(0,0,0,.04);
      }
      .dt-container .dt-button:hover{
        background:#1f2937 !important;
        border-color:#1f2937 !important;
      }

      /* Pagination */
      .dt-container .dt-paging button{
        border-radius:.5rem;
        border:1px solid #e5e7eb;
        background:#fff;
        color:#111827;
      }
      .dt-container .dt-paging .current{
        background:#111827;
        color:#fff;
        border-color:#111827;
      }
    </style>
  @endpush

  {{-- Scripts tetap sama --}}
  @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  @endpush
@endonce

<div class="dtflat overflow-x-auto">
  <table id="{{ $id }}" class="display stripe hover w-full text-sm">
    {{ $slot }}
  </table>
</div>

@push('scripts')
<script>
  $(function () {
    const $tbl = $('#{{ $id }}');

    // selector kolom yang diexport (kecuali yang punya class .no-export)
    const exportCols = ':visible:not(.no-export)';

    const options = {
      responsive: false,
      scrollX: true,
      pageLength: {{ $pageLength }},
      lengthMenu: {!! $lengthMenu !!},
      order: [{!! $order !!}],
      language: { url: 'https://cdn.datatables.net/plug-ins/2.1.6/i18n/id.json' },
    };

    @if($buttons)
      // Tata letak modern (DataTables v2) — tombol di kanan atas
      options.layout = {
        topStart: 'pageLength',
        topEnd: 'buttons'
      };

      options.buttons = [
        {
          extend: 'excelHtml5',
          title: document.title || 'Data',
          filename: (document.title || 'data').toLowerCase().replace(/\s+/g,'-') + '-' + (new Date()).toISOString().slice(0,10),
          text: `
            <span class="dtb-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="16" height="16">
                <path fill="currentColor" d="M4 4h16v4h-2V6H6v12h12v-2h2v4H4V4Zm9.5 5h2l-2.75 4 2.75 4h-2l-1.75-2.75L8 17h-2l2.75-4L6 9h2l1.75 2.75L13.5 9Z"/>
              </svg>
            </span>
            <span class="dtb-label">Excel</span>
          `,
          exportOptions: {
            columns: exportCols,
            format: {
              body: (data, row, col, node) => $(node).text().trim() // strip HTML
            }
          }
        },
        {
          extend: 'pdfHtml5',
          title: document.title || 'Data',
          filename: (document.title || 'data').toLowerCase().replace(/\s+/g,'-') + '-' + (new Date()).toISOString().slice(0,10),
          orientation: 'portrait',
          pageSize: 'A4',
          text: `
            <span class="dtb-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="16" height="16">
                <path fill="currentColor" d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Zm8 1.5V8h4.5L14 3.5ZM7 12h10v1.5H7V12Zm0 3h7v1.5H7V15Z"/>
              </svg>
            </span>
            <span class="dtb-label">PDF</span>
          `,
          exportOptions: {
            columns: exportCols,
            format: { body: (data, row, col, node) => $(node).text().trim() }
          },
          customize: (doc) => {
            doc.styles.tableHeader = {
              fillColor: '#111827',
              color:'#FFFFFF',
              bold:true,
              alignment:'left'
            };
            doc.styles.tableBodyEven = { fillColor: '#F9FAFB' };
            doc.styles.tableBodyOdd  = { fillColor: '#FFFFFF' };
            doc.defaultStyle.fontSize = 10;
            doc.content[0].text = (document.title || 'Data');
            doc.pageMargins = [24,24,24,24];
          }
        },
        {
          extend: 'print',
          title: document.title || 'Data',
          text: `
            <span class="dtb-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="16" height="16">
                <path fill="currentColor" d="M6 7V3h12v4H6Zm0 10v4h12v-4H6Zm-2-1a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-1v-3H5v3H4Z"/>
              </svg>
            </span>
            <span class="dtb-label">Cetak</span>
          `,
          exportOptions: {
            columns: exportCols,
            format: { body: (data, row, col, node) => $(node).text().trim() }
          },
          customize: (win) => {
            const css = `
              body { -webkit-print-color-adjust: exact; }
              table { font-size:12px; }
              thead th { background:#111827 !important; color:#fff !important; }
              tbody tr:nth-child(even) td { background:#F9FAFB !important; }
            `;
            const style = win.document.createElement('style');
            style.type = 'text/css';
            style.appendChild(win.document.createTextNode(css));
            win.document.head.appendChild(style);
          }
        },
        {
          extend: 'colvis',
          text: 'Kolom',
          postfixButtons: ['colvisRestore']
        }
      ];
    @else
      // Tanpa tombol export, hanya pageLength & search standar
      options.layout = {
        topStart: 'pageLength'
      };
    @endif

    const table = $tbl.DataTable(options);

    // Bisa kamu panggil kalau tabel ditaruh di dalam tab/modal:
    // document.dispatchEvent(new Event('datatable:recalc'));
    document.addEventListener('datatable:recalc', () => table.columns.adjust());
  });
</script>
@endpush
