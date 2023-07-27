{{-- This is Department Ward Schedule View --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Department Ward Schedule</title>
    <link href="{{ asset('import/assets/css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" rel="stylesheet"/>  
    <link href="{{ asset('import/assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('import/assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-list toggle-sidebar-btn"></i> &nbsp;
                {{ Auth::user()->department }} Ward Schedule 
            </h2>
        </x-slot>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

          <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
            <a class="nav-link " data-bs-target="#dep-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-building"></i><span>Department Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="dep-nav" class="nav-content  " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('calendar.depschedule') }}">
                  <i class="bi bi-grid"></i><span>On Call Schedule</span>
                </a>
              </li>
              <li>
                <a href="{{ route('calendar.view-ward') }}">
                  <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                </a>
              </li>
              <li>
                <a href="{{ route('calendar.view-shift') }}">
                  <i class="bi bi-person-workspace"></i><span>Shift Schedule</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed" href="{{ route('calendar.yourschedule') }}">
              <i class="bi bi-calendar-event"></i>
              <span>Your Schedule</span>
              </a>
          </li>
          @if (Auth::check() && Auth::user()->role === 'scheduler')
          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-pencil"></i><span>Create Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                  <a href="{{ route('create-oncall') }}">
                    <i class="bi bi-grid"></i><span>On Call Schedule</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('create-ward') }}">
                    <i class="bi bi-hospital"></i><span>Ward Schedule</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('create-shift') }}">
                    <i class="bi bi-person-workspace"></i><span>Shift Schedule</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#change-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-check-circle"></i><span>Changes Requested</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="change-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('review') }}">
                      <i class="bi bi-check-circle"></i><span>Review Changes Requested</span>
                    </a>
                </li>
                <li>
                  <a href="{{ route('reviewHistory') }}">
                    <i class="bi bi-clock-history"></i><span>Changes Requested History</span>
                  </a>
                </li>
              </ul>
            </li>
            @endif
        </aside><!-- End Sidebar-->
               
        <main id="main" class="main">

            <section class="section">
              <div class="row">
        
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                        <br>
                        <div id="calendar"></div>
                        <div class="text-right">
                            <button id="print" class="btn btn-primary float-right"><i class="bi bi-printer-fill"></i> Print Schedule</button>
                        </div>
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
                var schedule = @json($events);

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
                    events: schedule,
                    displayEventTime: false,
                    selectable: true,
                    selectHelper: true,
                    eventDrop: function(event) {
                        var id = event.id;
                        var ward = event.ward;
                        var start_date = moment(event.start).format('YYYY-MM-DD');
                        var end_date = start_date;
                        element.addClass('ward-' + ward);
                        $.ajax({
                            url:"{{ route('assign.update', '') }}" +'/'+ id,
                            type:"PATCH",
                            dataType:'json',
                            data:{ start_date, end_date },
                            success:function(response)
                            {
                                swal("Success", "New Date Updated!", "success");
                            },
                            error:function(error)
                            {
                                console.log(error)
                            },
                        });
                    },
                    eventClick: function(event){
                        $('#modalRemove').modal('toggle');
                        var id = event.id;
                        $('#saveBtn').click(function() {                            
                            $.ajax({
                                url:"{{ route('assign.delete', '') }}" +'/'+ id,
                                type:"DELETE",
                                dataType:'json',
                                success:function(response)
                                {
                                    $('#modalRemove').modal('hide')
                                    $('#calendar').fullCalendar('removeEvents', response);
                                    swal("Success", "The doctor has been removed!", "success");
                                    // swal("Good job!", "Event Deleted!", "success");
                                },
                                error:function(error)
                                {
                                    console.log(error)
                                },
                            });
                        });
                    }
                })
            });
            $('#print').on('click', function() {
                window.print();
            });
            document.getElementById('generate').addEventListener('click', function() {
                $('#modalGenerate').modal('toggle');
                $('#saveBtn2').click(function() {
                    fetch('/assign', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        // Handle the response from the server if needed
                        if (response.ok) {
                            // Refresh the page
                            $('#modalGenerate').modal('hide')
                            location.reload();
                            // swal("Success", "New schedule generated!", "success");
                        } else {
                            throw new Error('Request failed.');
                        }
                    })
                    .catch(error => {
                        // Handle any errors that occur during the request
                        console.error(error);
                    });
                });
            });
        </script>
        <script src="{{ asset('import/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/quill/quill.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('import/assets/vendors/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('import/assets/js/mains.js') }}"></script>
    </x-app-layout>

</body>
</html>