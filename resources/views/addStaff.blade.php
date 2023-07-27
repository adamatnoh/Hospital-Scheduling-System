<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Add New Account</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('import/assets/css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
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
                {{ __('Admin | Add New Account') }}
            </h2>
        </x-slot>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">
  
            <li class="nav-item">
                <a class="nav-link " href="{{ route('staff-form') }}" :active="request()->routeIs('calendar.depschedule')">
                <i class="bi bi-building"></i>
                <span>Add New Account</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('manageStaff') }}">
                <i class="bi bi-calendar-event"></i>
                <span>Manage Staff Account</span>
                </a>
            </li>
            
        </aside><!-- End Sidebar-->    

        <main id="main" class="main">

            <section class="section">
              <div class="row">
        
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="leaveForm">Name:&nbsp;</label><br>
                            <input type="text" id="name" placeholder="New doctor's name..">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="leaveForm">Department:&nbsp;&nbsp;&nbsp;</label><br>
                            <input type="text" id="department" placeholder="New doctor's department..">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="leaveForm">Role:</label><br>
                            <input type="text" id="role" placeholder="New doctor's role..">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="leaveForm">Email:</label><br>
                            <input type="email" id="email" placeholder="New doctor's email..">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="leaveForm">Password:</label><br>
                            <input type="text" id="password" placeholder="Set a password..">
                        </div>
                        <br><br>
                        <div class="form-group text-right"> 
                            <button class="btn btn-primary" id="saveBtn">Submit</button>
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
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#saveBtn', function() {
                                    
                var name = $('#name').val();
                var department = $('#department').val();
                var role = $('#role').val();
                var email = $('#email').val();
                var password = $('#password').val();

                $.ajax({
                    url:"{{ route('addStaff') }}",
                    type:"POST",
                    dataType:'json',
                    data:{ name, department, role, email, password },
                    success:function(response)
                    {
                        Swal.fire("Success", "New Account Created!", "success");
                        setTimeout(function() {
                           window.location.href = "{{ route('manageStaff') }}";     
                        }, 2000);
                        
                    },
                    error:function(error)
                    {
                        Swal.fire('Error', 'Please fill in all the fields.', 'error');
                        if(error.responseJSON.errors) {
                            $('#titleError').html(error.responseJSON.errors.title);
                        }
                        return;
                    },
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