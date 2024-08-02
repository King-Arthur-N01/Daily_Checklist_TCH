require('./bootstrap');

//fullcalendar jawascript
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import multiMonthPlugin from '@fullcalendar/multimonth';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [multiMonthPlugin],
        initialView: 'multiMonthYear',
        multiMonthMaxColumns: 12,
        events: '/machineschedule/calendar/read' // URL to fetch events
    });
    calendar.render();
});
