<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')}}" rel="stylesheet">
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@1.10.0/dist/scheduler.min.css" rel="stylesheet"> --}}

    {{-- <link href='https://unpkg.com/@fullcalendar/common@5.10.1/main.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/@fullcalendar/resource-timeline@5.10.1/main.min.css' rel='stylesheet'> --}}
    @stack('style')
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="card-body">
            <div class="calendar">
                <div id="calendar" data-id="{{ $id }}"></div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>











    <!-- FullCalendar scripts -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@1.10.0/dist/scheduler.min.js"></script> --}}

    {{-- <script src='https://unpkg.com/@fullcalendar/common@5.10.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/resource-timeline@5.10.1/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/interaction@5.10.1/main.min.js'></script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                plugins: [ 'resourceTimeline' ],
                editable: false,
                initialView: "resourceTimelineDay",
                aspectRatio: 2,
                headerToolbar: {
                    left: "today prev,next",
                    center: "title",
                    right: "resourceTimelineDay,resourceTimelineMonth,resourceTimelineYear",
                },
                // events: [],
            });
            calendar.render();
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendar = $('#calendar').fullCalendar({
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                // plugins: [ 'resourceTimeline', 'interaction' ],
                selectable:false,
                editable:false,
                initialView: "resourceTimeline",
                aspectRatio: 2,
                header:{
                    left: "today prev,next",
                    center: "title",
                    right: "resourceTimelineDay,resourceTimelineMonth,resourceTimelineYear",
                },
                events: '/schedule/calendar/read',
            });
            calendar.render();
        });
    </script> --}}
</body>
</html>
