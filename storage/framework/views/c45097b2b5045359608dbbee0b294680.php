<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HSS | Leave Application</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link href="<?php echo e(asset('import/assets/css/styles.css')); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <link href="<?php echo e(asset('import/assets/vendors/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/quill/quill.snow.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/quill/quill.bubble.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/remixicon/remixicon.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('import/assets/vendors/simple-datatables/style.css')); ?>" rel="stylesheet">

</head>
<body>
    
    <?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-list toggle-sidebar-btn"></i> &nbsp;
                <?php echo e(__('Leave Application')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Leave Application</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('calendar.oncall')); ?>">
                <i class="bi bi-grid"></i>
                <span>On Call Application</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo e(route('calendar.history')); ?>">
                <i class="bi bi-clock-history"></i>
                <span>Application History</span>
                </a>
            </li>
            
        </aside><!-- End Sidebar-->
        
        <!-- Modal -->
        <div class="modal fade" id="leaveReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Review leave application</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reviewName">Name:</label><br>
                            <input class="form-control" id="reviewName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewDepartment">Department:</label><br>
                            <input class="form-control" id="reviewDepartment" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewStartDate">Start Date:</label><br>
                            <input class="form-control" id="reviewStartDate" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewEndDate">End Date:</label><br>
                            <input class="form-control" id="reviewEndDate" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewDays">Total day(s) applied:</label><br>
                            <input class="form-control" id="reviewDays" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reviewReason">Reason:</label><br>
                            <input class="form-control" id="reviewReason" rows="3" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id='closeModal' class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button id="confirmBtn" class="btn btn-primary">Confirm</button>
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
                        <div class="form-group">
                            <label for="leaveForm">Start date:&nbsp;</label>
                            <input type="date" id="sDate">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="leaveForm">End date:&nbsp;&nbsp;&nbsp;</label>
                            <input type="date" id="eDate">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="leaveForm">Reason:</label>
                            <textarea class="form-control" id="reason" rows="3" placeholder="Enter your reason for leave here..."></textarea>
                        </div>
                        <br><br>
                        <div class="form-group text-right"> 
                            <button class="btn btn-primary" id="saveBtn">Apply</button>
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
                    var title = "<?php echo e(Auth::user()->name); ?>";
                    var user_id = "<?php echo e(Auth::user()->id); ?>";
                    var department = "<?php echo e(Auth::user()->department); ?>";
                    var reason = $('#reason').val();
                    var start_date = $('#sDate').val();
                    var end_date = $('#eDate').val();
                    var status = "Pending";
                    var startDateObj = new Date(start_date);
                    var endDateObj = new Date(end_date);
                    var timeDiff = Math.abs(endDateObj.getTime() - startDateObj.getTime());
                    var totalDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1);

                    $('#reviewName').val(title);
                    $('#reviewDepartment').val(department);
                    $('#reviewStartDate').val(start_date);
                    $('#reviewEndDate').val(end_date);
                    $('#reviewDays').val(totalDays + " day(s)");
                    $('#reviewReason').val(reason);

                    // Show the modal
                    if (reason === '') {
                        Swal.fire('Error', 'Please fill in the reason', 'error');
                        return;
                    }

                    $('#leaveReviewModal').modal('show');
                });

                $(document).on('click', '#confirmBtn', function() {
                    $('#leaveReviewModal').modal('hide');
                    var title = "<?php echo e(Auth::user()->name); ?>";
                    var user_id = "<?php echo e(Auth::user()->id); ?>";
                    var department = "<?php echo e(Auth::user()->department); ?>";
                    var reason = $('#reason').val();
                    var start_date = $('#sDate').val();
                    var end_date = $('#eDate').val();
                    var status = "Pending";

                    $.ajax({
                        url: "<?php echo e(route('calendar.storeLeave')); ?>",
                        type: "POST",
                        dataType: 'json',
                        data: { title, user_id, department, reason, start_date, end_date, status },
                        success: function(response) {
                            Swal.fire("Success", "Date Applied!", "success");
                        },
                        error: function(error) {
                            Swal.fire('Error', 'Please fill in all the fields.', 'error');
                            if (error.responseJSON.errors) {
                                $('#titleError').html(error.responseJSON.errors.title);
                            }
                            return;
                        },
                    });
                });
            });
        </script>
        <script src="<?php echo e(asset('import/assets/vendors/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/chart.js/chart.umd.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/echarts/echarts.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/quill/quill.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/simple-datatables/simple-datatables.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/tinymce/tinymce.min.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/vendors/php-email-form/validate.js')); ?>"></script>
        <script src="<?php echo e(asset('import/assets/js/mains.js')); ?>"></script>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

</body>
</html><?php /**PATH E:\@UTM\FYP\HSS\resources\views/calendar/leave.blade.php ENDPATH**/ ?>