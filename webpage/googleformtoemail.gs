// Description:
// This function is used by alumni who want to propose an event
// to the alumni office.
// It takes responses from a google spread sheet and handles
// the responses on submission from a google form that feeds the
// spread sheet.

// sends google form response to an email account
function sendFormByEmail(e) {
  var email = "scualumnioffice@gmail.com";

  var txt ="";
  for (var field in e.namedValues) {
    txt += field + ' :: ' + e.namedValues[field].toString() + "\n\n";
  }

  MailApp.sendEmail(email, "Google Docs Form Submitted", txt);
}
