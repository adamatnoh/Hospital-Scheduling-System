<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .flex-container {
            display: flex;
        }

        .announcement-box {
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        .announcement-box img {
            max-width: 100%;
            max-height: 500px; /* Set the maximum height for the announcement images */
            object-fit: contain;
            margin: 10px auto; /* Add some margin to separate the images */
        }
    </style>
</head>
<body>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        {{-- <x-application-logo class="block h-12 w-auto" /> --}}

        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            Welcome to Hospital Scheduling System!
        </h1>

        <p class="mt-6 text-gray-500 leading-relaxed">
            A schedule portal hospital scheduling system, that helps you to automate its manual scheduling process including the on-call, ward, and shift schedules. 
        </p>
    </div>

{{-- <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"> --}}
    
    <div class="flex-container">
        <div class="announcement-box">
            <h1 class="text-2xl font-medium text-gray-900">Announcement</h1><br>
            <div id="announcement-images">
                <img src="images/1.jpg" alt="Image 1">
                <img src="images/2.jpg" alt="Image 2">
                <img src="images/3.jpg" alt="Image 3">
            </div>
        </div>
        {{-- <div class="employee-box">
            <div class="employee-card">
                <h1 class="text-2xl font-medium text-gray-900">Employee of the Month</h1><br>
                <img class="employee-image" src="images/dr.jpg" alt="Employee of the Month">
                <div class="employee-details">
                    <div>
                        <p>Name: John Doe</p>
                        <p>Department: Sales</p>
                        <div class="star-animation"></div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>


        
{{-- </div> --}}    

    <!-- Include Bootstrap JS (jQuery dependency) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        // Image slideshow for the announcement box
        var announcementImages = document.getElementById('announcement-images');
        var images = announcementImages.getElementsByTagName('img');
        var currentIndex = 0;

        // Hide all images except the first one
        for (var i = 1; i < images.length; i++) {
            images[i].style.display = 'none';
        }

        function changeImage() {
            images[currentIndex].style.display = 'none';
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].style.display = 'block';
        }

        setInterval(changeImage, 3000);
    </script>
</body>
</html>
