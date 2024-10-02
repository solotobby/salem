@extends('layouts.master')
@section('title', 'Book')

@section('style')

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
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
                <h4 class="fs-18 fw-semibold m-0">Book</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Book</li>
                </ol>
            </div>
        </div>

      

        <div class="container mt-5">
           
        
            <div id="calendar"></div>
            {{-- <form id="booking-form" action="" method="POST" style="display:none;">
                @csrf
                <input type="hidden" id="availability_id" name="availability_id">
            </form> --}}
            <!-- Modal -->
    <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availabilityModalLabel">Available Times</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="available-times"></div>
                    <label for="duration" class="form-label">Select Duration:</label>
                    <select id="duration" class="form-select">
                        <option value="15">15 Minutes</option>
                        <option value="30">30 Minutes</option>
                        <option value="60">1 Hour</option>
                        <option value="120">2 Hours</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="book-slot" class="btn btn-primary">Book Slot</button>
                </div>
            </div>
        </div>
    </div>

    <form id="booking-form" action="" method="POST" style="display:none;">
        @csrf
        <input type="hidden" id="availability_id" name="availability_id">
        <input type="hidden" id="selected_time" name="selected_time">
    </form>

        </div>



    </div>
</div>
@endsection

@section('script')

<!-- FullCalendar JS and Dependencies -->
<!-- FullCalendar JS and Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            editable: false, // Users can't modify the events
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            validRange: {
                start: new Date().toISOString().split("T")[0] // Only future dates enabled
            },
            events: [
                @foreach($availabilities as $availability)
                {
                    id: '{{ $availability->id }}',
                    title: '{{ $availability->is_booked ? "Booked" : "Available" }}',
                    title: '{{ $availability->is_booked ? "Booked" : "Available Period" }}',
                    start: '{{ $availability->start_date }}T{{ $availability->start_time }}',
                    end: '{{ $availability->end_date ? $availability->end_date : $availability->start_date }}T{{ $availability->end_time ? $availability->end_time : $availability->start_time }}', // End date and time
                    className: '{{ $availability->is_booked ? "fc-event-booked" : "fc-event-available" }}',
                },
                @endforeach
            ],
    
            eventClick: function(info) {
                // Only allow booking if the slot is available
                if (info.event.classNames.includes('fc-event-available')) {
                    if (confirm("Do you want to book this slot?")) {
                        document.getElementById('availability_id').value = info.event.id;
                        document.getElementById('booking-form').action = '/availability/book/' + info.event.id;
                        document.getElementById('booking-form').submit();
                    }
                } else {
                    alert("This slot is already booked.");
                }
            }
        });
        calendar.render();
    });

    </script>

@endsection
