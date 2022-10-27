@php
    $datatable_options['ajax'] = $source;
    $datatable_options['columns'] = $datatable_columns;   
    $datatable_options['bStateSave'] = true;   
    $datatable_options['stateDuration'] = 10 * 60;
    $datatable_options['lengthMenu'] = [25, 50, 100];
@endphp

<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped text-nowrap" data-default-src-url="{{ $source }}"
           data-src-url="{{ $source }}" data-columns="{{ json_encode($datatable_columns)}}" id="{{ $datatable_id }}"
           data-dt="{{ json_encode($datatable_options) }}" data-empty-text="{{ $empty_datatable_html }}"
           style="margin: 0!important;width:100% !important;">
        <thead>
        <tr>
            @foreach($table_header as $single_column)
                <th class="@if($table_header_center_text) text-center @endif" style="width:1%">{!! $single_column !!}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('css')
    <link href="{{asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/axios/axios.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            init_dt('#{{ $datatable_id }}')
        });
    </script>
@endpush


