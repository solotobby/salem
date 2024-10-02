@extends('layouts.master')
@section('title', 'Set Availability')

@section('style')

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- FullCalendar CSS -->
   <!-- FullCalendar CSS -->
   <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
   <style>
       /* Custom Colors for Events */
       .fc-event-available {
           background-color: green !important;
           color: white !important;
       }
       .fc-event-booked {
           background-color: yellow !important;
           color: black !important;
       }
   </style>


@endsection

@section('content')

<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Set Availability</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Availability</li>
                </ol>
            </div>
        </div>

      

        <div class="container">

            <!-- Calendar -->
    <div id="calendar"></div>

    <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availabilityModalLabel">Set Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="availability-form" action="{{ route('availability.store') }}" method="POST">
                        @csrf
                        <!-- Availability Type -->
                        <div class="mb-3">
                            <label for="availability_type" class="form-label">Availability Type</label>
                            <select id="availability_type" name="type" class="form-select" required>
                                <option value="day">Single Day</option>
                                <option value="range">Range of Days</option>
                                {{-- <option value="week">One Week</option>
                                <option value="month">One Month</option> --}}
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>

                        <!-- End Date (only if range is selected) -->
                        <div class="mb-3" id="end_date_container" style="display: none;">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>

                        <!-- Time Selection -->
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>

                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>

                        <!-- Timezone Selection -->
                        <div class="mb-3">
                            <label for="timezone" class="form-label">Select Timezone</label>
                            <select id="timezone" name="timezone" class="form-select" required>
                                @foreach (timezone_identifiers_list() as $timezone)
                                    <option value="{{ $timezone }}">{{ $timezone }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Availability</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

    </div>
</div>
@endsection

@section('script')

<!-- FullCalendar JS and Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true, // Allows selection of time slots
            editable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            // Disable past dates
            validRange: {
                start: new Date().toISOString().split("T")[0] // Only future dates enabled
            },
            events: [
                @foreach($availabilities as $availability)
                {
                    title: '{{ $availability->is_booked ? "Booked" : "Your Available Period" }}',
                    start: '{{ $availability->start_date }}T{{ $availability->start_time }}',
                    end: '{{ $availability->end_date ? $availability->end_date : $availability->start_date }}T{{ $availability->end_time ? $availability->end_time : $availability->start_time }}', // End date and time
                    className: '{{ $availability->is_booked ? "fc-event-booked" : "fc-event-available" }}',
                    extendedProps: {
                    description: 'Start date: {{ $availability->start_date }} @ {{ $availability->start_time }}\nEnd date: {{ $availability->end_date ? $availability->end_date : $availability->start_date }} @ {{ $availability->end_time ? $availability->end_time : $availability->start_time }}'
                    }
                },
                @endforeach
            ],
            dateClick: function(info) {
                // Populate start_date when a date is clicked
                document.getElementById('start_date').value = info.dateStr;
    
                // Check the availability type
                var availabilityType = document.getElementById('availability_type').value;
                
                // If the type is "range", show the end date input and allow selection of end date
                if (availabilityType === 'range') {
                    document.getElementById('end_date_container').style.display = 'block'; // Show end date field
                } else {
                    document.getElementById('end_date_container').style.display = 'none'; // Hide end date field
                    document.getElementById('end_date').value = ''; // Clear the end date field if not needed
                }
    
                // Open the modal
                var modal = new bootstrap.Modal(document.getElementById('availabilityModal'));
                modal.show();
            },
                    // Show info on mouse hover
            eventMouseEnter: function(info) {
                var tooltip = new bootstrap.Popover(info.el, {
                    title: info.event.title,
                    content: info.event.extendedProps.description,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
                tooltip.show();
            },

            // Remove the popover when the mouse leaves the event
            eventMouseLeave: function(info) {
                var popover = bootstrap.Popover.getInstance(info.el);
                if (popover) {
                    popover.dispose();
                }
            },
        });
        calendar.render();
    
        // Handle availability type change to show/hide end date field
        document.getElementById('availability_type').addEventListener('change', function() {
            var endDateContainer = document.getElementById('end_date_container');
            var availabilityType = this.value;
    
            if (availabilityType === 'range') {
                endDateContainer.style.display = 'block'; // Show end date for range selection
            } else {
                endDateContainer.style.display = 'none'; // Hide end date for single-day/week/month
                document.getElementById('end_date').value = ''; // Clear end date if not applicable
            }
        });
    
        // When the form is submitted, check that end date is after the start date (for range)
        document.getElementById('availability-form').addEventListener('submit', function(event) {
            var availabilityType = document.getElementById('availability_type').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;
    
            // If type is 'range', check that end date is after start date
            if (availabilityType === 'range' && startDate && endDate && new Date(endDate) < new Date(startDate)) {
                alert("End date must be after start date for range availability.");
                event.preventDefault(); // Prevent form submission if dates are incorrect
            }
        });
    });
    </script>
    

@endsection
