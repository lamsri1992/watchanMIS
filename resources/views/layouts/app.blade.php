<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WATCHAN MIS 4.0</title>
    <link href="{{ asset('vendor/fontawesome6/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('sb/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/preload/preload.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/datepicker/jquery.datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css' rel='stylesheet' />
</head>

<body id="page-top">
    <div class="preloader">
        <div class="spinner"></div>
        <span id="loading-msg"></span>
    </div>
    <div id="wrapper">
        @include('layouts.side')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.head')
                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            @include('layouts.foot')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    @include('layouts.extra')
</body>

<script src="{{ asset('sb/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sb/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sb/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('sb/js/sb-admin-2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('vendor/datepicker/jquery.datetimepicker.full.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('vendor/preload/preload.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.js'></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 // DATATABLES
 $(document).ready(function () {
    $('#tableBasic').dataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
            oLanguage: {
            oPaginate: {
                sFirst: '<small>หน้าแรก</small>',
                sLast: '<small>หน้าสุดท้าย</small>',
                sNext: '<small>ถัดไป</small>',
                sPrevious: '<small>กลับ</small>'
            },
                sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
                sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
                sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
                sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
            },
        });
    });

    $(document).ready(function () {
        $('#tableExport').dataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"top"Blf>rt<"bottom"ip><"clear">',
            buttons: {
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> พิมพ์',
                        className: 'btn btn-info',
                        footer: true
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success',
                        footer: true
                    }
                ],
                dom: {
                    button: {
                        className: 'btn-sm'
                    }
                }
            },
            ordering: false,
            bLengthChange: false,
            oLanguage: {
                oPaginate: {
                    sFirst: '<small>หน้าแรก</small>',
                    sLast: '<small>หน้าสุดท้าย</small>',
                    sNext: '<small>ถัดไป</small>',
                    sPrevious: '<small>กลับ</small>'
                },
                sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
                sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
                sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
                sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
            },
        });
    });

 // SELECT2
$(document).ready(function() {
    $('.basic-select2').select2({ 
        width: '100%',
        placeholder: 'กรุณาเลือก',
    });
});

$(document).ready(function() {
    $('.basic-multiple').select2({
        width: '100%',
        tags: true,
    });
});

// Disabled Sorting When Select
$("select").on("select2:select", function (evt) {
  var element = evt.params.data.element;
  var $element = $(element);

  $element.detach();
  $(this).append($element);
  $(this).trigger("change");
});

// DATATIME_PICKER 
$(function() {
    $.datetimepicker.setLocale('th');
    $(".basicDate").datetimepicker({
        format: 'Y-m-d',
        lang: 'th',
        timepicker: false,
    });
});

// DATATIME_PICKER 
$(function() {
    $.datetimepicker.setLocale('th');
    $(".basicDateTime").datetimepicker({
        format: 'Y-m-d H:i',
        lang: 'th',
        timepicker: true,
    });
});

</script>
@if($message = Session::get('success'))
<script>
    $(function() {
        var Toast = Swal.mixin({
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timer: 10000
        });
            Toast.fire({
            icon: 'success',
            title: '{{ $message }}'
        })
    });
</script>
@endif
@section('script')
@show

</html>
