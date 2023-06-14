<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | On Call Application</title>
    <link href="{{ asset('import/assets/css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <link href="{{ asset('import/assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">

</head>
<body>
    
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-list toggle-sidebar-btn"></i> &nbsp;
                {{ __('On Call Application') }}
            </h2>
        </x-slot>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('calendar.leave') }}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Leave Application</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="">
                <i class="bi bi-grid"></i>
                <span>On Call Application</span>
                </a>
            </li>
            
        </aside><!-- End Sidebar-->
         
        <!-- Modal -->
        <div class="modal fade" id="modalReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">On Call Application</h5>
                <button type="button" class="close"data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?</p>
                  </div>
                <div class="modal-footer">
                <button id="saveBtn" class="btn btn-primary">Yes</button>
                <button id='closeModal' class="btn btn-danger" data-bs-dismiss="modal">No</button>
                </div>
            </div>
            </div>
        </div>

        <main id="main" class="main">

            <section class="section">
              <div class="row">
        
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                        <br>
                        <div id="calendar"></div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
        
          </main><!-- End #main -->
        
          <!-- ======= Footer ======= -->
          <footer id="footer" class="footer">
            <div class="copyright">
              &copy; Copyright <strong><span>Hospital Scheduling System</span></strong>. All Rights Reserved
            </div>
          </footer><!-- End Footer -->
        
          <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        
                
          <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev, next, today',
                        center: 'title',
                        right: 'month, agendaWeek, agendaDay',
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDays) {
                        $('#modalReason').modal('toggle');

                        $('#saveBtn').click(function() {
                            var title = "{{ Auth::user()->name }}";
                            var user_id = "{{ Auth::user()->id }}";
                            var department = "{{ Auth::user()->department }}";
                            var reason = $('#reason').val();
                            var start_date = moment(start).format('YYYY-MM-DD');
                            var end_date = moment(end).format('YYYY-MM-DD');
                            var status = "No";
                            
                            $.ajax({
                                url:"{{ route('calendar.storeOnCall') }}",
                                type:"POST",
                                dataType:'json',
                                data:{ title, user_id, department, reason, start_date, end_date, status },
                                success:function(response)
                                {
                                    $('#modalReason').modal('hide')
                                    $('#calendar').fullCalendar('renderEvent', {
                                        'title': response.title,
                                        'department': response.department,
                                        'reason': response.reason,
                                        'start' : response.start,
                                        'end'  : response.end,
                                        'color' : response.color
                                    });
                                },
                                error:function(error)
                                {
                                    if(error.responseJSON.errors) {
                                        $('#titleError').html(error.responseJSON.errors.title);
                                    }
                                },
                            });
                        });
                    }
                })
            });
        </script>
        <script src="{{ asset('import/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('import/assets/js/mains.js') }}"></script>
    </x-app-layout>

</body>
</html>