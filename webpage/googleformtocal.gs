// Description:
// Takes google form submission and adds it to a Google Calendar
// This is used by the Alumni office staff to add events to
// the event calendar from the website.

//Load the library once
var moment = Moment.load();

var GLOBAL = {
  //the id of the form we will use to create calendar events
  formId : "1n64JdaYL8eItVw_EROE9XpRSjBPNMN2xjE1tV8nb5hA",

  //the id of the calendar we will create events on
  calendarId : "scualumnioffice@gmail.com",

  //a mapping of form item titles to sections of the
  //calendar event
  formMap : {
    eventTitle: "Event Title",
    startTime : "Event Date and Start Time",
    endTime: "Event End Time",
    description: "Event Description",
    location: "Event Location",
    email: "Add Guests",
  },
}

//function called by the form submission event
function onFormSubmit() {
  //store incoming form responses in an event object variable
  var eventObject = getFormResponse();
  //use the event object to create a new calendar event
  //store the event in a variable called event
  var event = createCalendarEvent(eventObject);
}

function getFormResponse() {
  // Get a form object by opening the form using the
  // form id stored in the GLOBAL variable object
  var form = FormApp.openById(GLOBAL.formId),
      //Get all responses from the form.
      //This method returns an array of form responses
      responses = form.getResponses(),
      //find the length of the responses array
      length = responses.length,
      //find the index of the most recent form response
      //since arrays are zero indexed, the last response
      //is the total number of responses minus one
      lastResponse = responses[length-1],
      //get an array of responses to every question item
      //within the form
      itemResponses = lastResponse.getItemResponses(),
      //create an empty object to store data from the
      //last form response
      eventObject = {};

  for (var i = 0, x = itemResponses.length; i<x; i++) {
    //Get the title of the form item being iterated on
    var thisItem = itemResponses[i].getItem().getTitle(),
        //get the submitted response to the form item being
        //iterated on
        thisResponse = itemResponses[i].getResponse();
    //based on the form question title, map the response of the
    //item being iterated on into our eventObject variable
    //use the GLOBAL variable formMap sub object to match form
    //question titles to property keys in the event object
    switch (thisItem) {
      case GLOBAL.formMap.eventTitle:
        eventObject.title = thisResponse;
        break;
      case GLOBAL.formMap.startTime:
        eventObject.startTime = thisResponse;
        break;
      case GLOBAL.formMap.endTime:
        eventObject.endTime = thisResponse;
        break;
      case GLOBAL.formMap.description:
        eventObject.description = thisResponse;
        break;
      case GLOBAL.formMap.location:
        eventObject.location = thisResponse;
        break;
      case GLOBAL.formMap.email:
        eventObject.email = thisResponse;
        break;
    }
  }
  return eventObject;
}

function createCalendarEvent(eventObject) {
  //Get a calendar object by opening the calendar using the
  //calendar id stored in the GLOBAL variable object
  var calendar = CalendarApp.getCalendarById(GLOBAL.calendarId),
      title = eventObject.title,
      startTime = moment(eventObject.startTime).toDate(),
      endTime = moment(eventObject.endTime).toDate();
  var options = {
    description : eventObject.description,
    guests : eventObject.email,
    lcoation: eventObject.location,
  };
  try {
    //create a calendar event
    var event = calendar.createEvent(title, startTime,
                                     endTime, options)
    } catch (e) {
      //delete the guest property from the options variable,
      //as an invalid email address with cause this method
      //to throw an error.
      delete options.guests
      //create the event without including the guest
      var event = calendar.createEvent(title, startTime, endTime, options)
      }
  return event;
}
