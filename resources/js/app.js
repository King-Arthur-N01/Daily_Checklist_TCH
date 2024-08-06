require("./bootstrap");

//fullcalendar jawascript
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import interactionPlugin from "@fullcalendar/interaction";
import multiMonthPlugin from "@fullcalendar/multimonth";
import resourceTimelinePlugin from "@fullcalendar/resource-timeline";

document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("calendar");

    let calendar = new Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        plugins: [resourceTimelinePlugin, interactionPlugin],
        initialView: "resourceTimelineYear",
        aspectRatio: 3,
        headerToolbar: {
            left: "today prev,next",
            center: "title",
            right: "resourceTimelineDay,resourceTimelineTenDay,resourceTimelineMonth,resourceTimelineYear",
        },
        views: {
            resourceTimelineTenDay: {
                type: "resourceTimeline",
                duration: { days: 10 },
                buttonText: "10 days",
            },
        },
        editable: false,
        resourceAreaHeaderContent: "Schedule",
        resources:"/machineschedule/calendar/read",
        events: "/machineschedule/calendar/read",
        // events:"https://fullcalendar.io/api/api/demo-feeds/events.json?single-day&for-resource-timeline",
    });
    calendar.render();
});
