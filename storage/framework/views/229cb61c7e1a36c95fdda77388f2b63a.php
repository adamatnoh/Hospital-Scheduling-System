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

        /* .employee-card {
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .employee-image {
            display: flex;
            flex-direction: column;
            align-items: center; 
            margin-top: auto;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            align-items: center; 
            margin-top: auto;
        }

        @keyframes star-pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.2);
            }
        } */
    </style>
</head>
<body>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        

        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            Welcome to Hospital Scheduling System!
        </h1>

        <p class="mt-6 text-gray-500 leading-relaxed">
            A schedule portal hospital scheduling system, that helps you to automate its manual scheduling process including the on-call, ward, and shift schedules. 
        </p>
    </div>


    
    <div class="flex-container">
        <div class="announcement-box">
            <h1 class="text-2xl font-medium text-gray-900">Announcement</h1><br>
            <div id="announcement-images">
                <img src="images/1.jpg" alt="Image 1">
                <img src="images/2.jpg" alt="Image 2">
                <img src="images/3.jpg" alt="Image 3">
            </div>
        </div>
        
    </div>


        
    

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
<?php /**PATH E:\@UTM\FYP\HSS\resources\views/components/welcome.blade.php ENDPATH**/ ?>