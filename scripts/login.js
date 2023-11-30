function Validate(form) {
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const hiddenField = document.getElementById("hiddenField");

  // * 1 function run to check all validation prerequisites.
  checkInputs();

  // ** Determines if one or more inputs have invalid entries as marked by checkInputs().
  if (!allFieldsValid()) {
    return false;
  }
  return true;

  // *
  function checkInputs() {
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const hiddenFieldValue = hiddenField.value.trim();

    ///////////////////
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailValue == "" || emailValue == null) {
      // Show and add error class
      setError(email, "Email required *");
    } else if (!emailRegex.test(emailValue)) {
      // Check if emailValue does not match the regex pattern
      setError(email, "Enter Valid Email *");
    } else {
      // If emailValue is not empty and passes the regex test, set it as valid
      setValid(email);
    }
    ///////////////////
    if (passwordValue == "" || passwordValue == null) {
      // Show and add error class
      setError(password, "Password required *");
    } else {
      setValid(password);
    }
    ///////////////////
  }

  // Adds invalidEntry class to an input''s parent if validation check is not passed
  function setError(input, message) {
    const formControl = input.parentElement; //form-control
    const small = formControl.querySelector("small");

    //add error message inside small
    small.innerText = message;
    formControl.className = "form-control invalidEntry";
  }

  // Adds validEntry class to an input's parent if validation check is not passed
  function setValid(input) {
    const formControl = input.parentElement; //form-control
    formControl.className = "form-control validEntry";
  }

  // **
  function allFieldsValid() {
    var allFieldsValid = document.getElementsByClassName("invalidEntry");
    if (allFieldsValid.length > 0) {
      return false;
    } else {
      return true;
    }
  }
}
