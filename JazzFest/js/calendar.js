/**
 * Created by Brendan Andres on 4/6/2016.
 */
$(document).ready(function () {

        var calendarDiv = $('#calendar');
        var fullCalendar = calendarDiv.fullCalendar(
            {
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,

                /**
                 * This function registers the user clicking on a specific day. Upon being clicked, it checks if
                 * an event exists on the current date and time. If not, it generates an event with a start time set to
                 * midnight (if on the month view) or the time that is clicked (on week/day view), ending two hours
                 * after that time. Currently the dates do not save because there is not database to save them to.
                 *
                 * Additionally, the calendar doesn't natively refresh to display these vents, so I have it set to
                 * automatically re-render the calendar to display the event without re-rendering the page itself.
                 *
                 * Finally, the events can be moved by clicking and dragging them to different locations. The time can
                 * be adjusted by dragging the bottom of the event up and down to fit the specific time frame (in half
                 * hour units) that the user desires.
                 *
                 * @param date
                 * @param jsEvent
                 * @param view
                 */
                dayClick: function (date, jsEvent, view) {

                    var events = calendarDiv.fullCalendar('clientEvents');

                    var exists = false;

                    if (!exists) {
                        var event = {
                            title: 'New Event',
                            start: date.toISOString(),
                            end: date.toISOString() + 1
                        };

                        calendarDiv.fullCalendar(
                            'renderEvent',
                            event,
                            true
                        );

                        calendarDiv.fullCalendar('rerenderEvents');
                    }
                },

                /**
                 * This allows the event to be edited. It currently edits the event when being clicked. In the end
                 * it's going to allow for every field of the event to be edited, but right now it currently changes
                 * it to preset fields.
                 *
                 * @param event
                 * @param element
                 */
                eventClick: function (event, element) {

                    event.title = "CLICKED!";

                    calendarDiv.fullCalendar('updateEvent', event);

                }
            }
        )
    }
);