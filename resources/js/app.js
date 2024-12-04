require("./bootstrap");

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from "@fullcalendar/interaction";
import resourceTimelinePlugin from "@fullcalendar/resource-timeline";

document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("calendar");
    let id = calendarEl.dataset.id; // Ambil ID dari atribut data-id
    let calendar = new Calendar(calendarEl, {
        schedulerLicenseKey: "CC-Attribution-NonCommercial-NoDerivatives",
        plugins: [resourceTimelinePlugin],
        timeZone: 'UTC',
        editable: false,
        // selectable:false,
        initialView: "resourceTimelineYear",
        aspectRatio: 2,
        firstDay: 1,
        resourceAreaHeaderContent: 'Machine',
        headerToolbar: {
            left: "today prev,next",
            center: "title",
            right: "resourceTimelineMonth,resourceTimelineYear",
        },
        eventTimeFormat: false,
        // eventTimeFormat: { // Format waktu
        //     hour: "2-digit",
        //     minute: "2-digit",
        //     hour12: false
        // },
        resources: `/schedule/view/resources/${id}`,
        events: `/schedule/view/events/${id}`,
        eventSourceSuccess: function(data) {
            console.log("Data JSON dari server:", data);
            return data;
        }
    });
    calendar.render();
});
