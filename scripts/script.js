"use strict";
//  This is the first pass of validation for AddCar.php and registration.php. If any of these checks fail, the form is not submitted and an error message is produced. If erroneous values make it through this Javascript check, the PHP error handling will take over. The error messages are indistinguishable whether the source so that the user does not recieve conflicting information.

// -----REGISTRATION.PHP VALIDATION-----
function validateUserRegForm() {
  emptyCheckerUserReg();
  //  NOTE: this function is called first so as to not have possible empty-value PHP error messages from being blocked by Javascript. This happens because being client-side, JS runs before server-side PHP, so for example if an input is empty, the "empty" PHP error message will be overwritten by JS regex-check error messages - the result being an empty field on submission will not show the user the correct error.

  //  receiving and storing the form entries
  //  NOTE: this method retrieves all entries as strings, so they are cast to type Number where applicable
  let username = document.forms["registration"]["username"].value;
  let fname = document.forms["registration"]["fname"].value;
  let lname = document.forms["registration"]["lname"].value;
  let phone = Number(document.forms["registration"]["phone"].value);
  let email = document.forms["registration"]["email"].value;
  let password = document.forms["registration"]["password"].value;

  //  preparing regexes for each form entry
  const usernameRegex = /^[a-zA-Z0-9]{5,20}$/;
  const namesRegex = /^[a-zA-Z]{2,50}$/;
  const phoneRegex = /^[0-9]{10,11}$/;
  const emailRegex = /([\w\-]+\@[\w\-]+\.[\w\-]+)/;
  const passwordRegex =
    /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$/;

  //  Executes a search on each string using a regular expression pattern, and returns an array containing the results of that search. If regex fails, it returns null
  const usernameCheck = usernameRegex.exec(username);
  const namesCheck = namesRegex.exec(fname, lname);
  const phoneCheck = phoneRegex.exec(phone);
  const emailCheck = emailRegex.exec(email);
  const passwordCheck = passwordRegex.exec(password);

  if (
    (usernameCheck, namesCheck, phoneCheck, emailCheck, passwordCheck === !null)
  ) {
    console.log("Form not submitted");
    // each error span receives a matching error to its PHP counterpart
    document.getElementById("usernameErr").innerHTML =
      "&nbsp Only letters & numbers, minimum 5 characters, maxiumum 20 allowed. &nbsp";
    document.getElementById("fnameErr").innerHTML =
      "&nbsp Only letters, minimum 2 characters, maxiumum 50 allowed. &nbsp";
    document.getElementById("lnameErr").innerHTML =
      "&nbsp Only letters, minimum 2 characters, maxiumum 50 allowed. &nbsp";
    document.getElementById("phoneErr").innerHTML =
      "&nbsp Minimum of 10 digits, maximum 11, no dashes between required. &nbsp";
    document.getElementById("emailErr").innerHTML =
      "&nbsp Invalid email format. &nbsp";
    document.getElementById("passwordErr").innerHTML =
      "&nbsp Password must be between 8 & 20 characters with at least one special character, one uppercase letter and one digit. &nbsp";

    return false;
    // the form interprets 'false' as to not submit the form
  } else {
    console.log("Success");
  }
  // }

  // -----ADDCAR.PHP VALIDATION-----

  function validateAddCarForm() {
    emptyCheckerAddCar();
    //  NOTE: this function is called first so as to not have possible empty-value PHP error messages from being blocked by Javascript. This happens because being client-side, JS runs before server-side PHP, so for example if an input is empty, the "empty" PHP error message will be overwritten by JS regex-check error messages - the result being an empty field on submission will not show the user the correct error.

    //  receiving and storing the form entries
    //  NOTE: this method retrieves all entries as strings, so they are cast to type Number where applicable. Year is checked differently near the end  of this function.
    let make = document.forms["addCar"]["make"].value;
    let model = document.forms["addCar"]["model"].value;
    let year = Number(document.forms["addCar"]["year"].value);
    let mileage = Number(document.forms["addCar"]["mileage"].value);
    let color = document.forms["addCar"]["color"].value;
    let asking_price = Number(document.forms["addCar"]["asking_price"].value);

    //  preparing regexes for each form entry
    const makeRegex = /^[a-zA-Z -]*$/;
    const modelRegex = /^[a-zA-Z0-9 +-]*$/;
    const mileageRegex = /^[0-9]{1,6}$/;
    const colorRegex = /^[a-zA-Z -]*$/;
    const askingPriceRegex = /^[0-9]{1,7}$/;

    //  Executes a search on each string using a regular expression pattern, and returns an array containing the results of that search. If regex fails, it returns null
    const makeCheck = makeRegex.exec(make);
    const modelCheck = modelRegex.exec(model);
    const mileageCheck = mileageRegex.exec(mileage);
    const colorCheck = colorRegex.exec(color);
    const askingPriceCheck = askingPriceRegex.exec(asking_price);

    if (
      (makeCheck,
      modelCheck,
      mileageCheck,
      colorCheck,
      askingPriceCheck === !null)
    ) {
      console.log("Form not submitted");
      // each error span receives a matching error to its PHP counterpart
      document.getElementById("makeErr").innerHTML =
        "&nbsp Only letters, dashes and spaces allowed &nbsp";
      document.getElementById("modelErr").innerHTML =
        "&nbsp Only letters, numbers, spaces, '+', '-' allowed &nbsp";
      document.getElementById("mileageErr").innerHTML =
        "&nbsp Please enter only digits &nbsp";
      document.getElementById("colorErr").innerHTML =
        "&nbsp Only letters, spaces and dashes allowed &nbsp";
      document.getElementById("askPriceErr").innerHTML =
        "&nbsp Only digits allowed &nbsp";

      //  the form interprets 'false' as to not submit the form
      return false;
    }

    //  fetches and stores current year to check against
    const currentYear = new Date().getFullYear();

    //  year checker
    if (year == "") {
      document.getElementById("yearErr").innerHTML =
        "&nbsp Field required &nbsp";
      return false;
    } else if (year < 1930 || year > currentYear) {
      document.getElementById("yearErr").innerHTML = "&nbsp Invalid Year &nbsp";
      return false;
    } else console.log("Success");
  } //end validateAddCarForm()

  //----------------------------EMPTY FORM CHECKERS------------------------------------
  //  checks for empty values (before regex checking)
  function emptyCheckerUserReg() {
    //  receiving and storing the form entries
    //  NOTE: this method retrieves all entries as strings, so they are cast to type Number where applicable
    let username = document.forms["registration"]["username"].value;
    let fname = document.forms["registration"]["fname"].value;
    let lname = document.forms["registration"]["lname"].value;
    let phone = Number(document.forms["registration"]["phone"].value);
    let email = document.forms["registration"]["email"].value;
    let password = document.forms["registration"]["password"].value;

    //  stores inputs as array, foreach loop feeds inputs into a switch when entries are empty or null and returns appropraite messages to the HTML error message spans
    let inputs = [username, fname, lname, phone, email, password];
    inputs.forEach((input) => {
      if (input === "" || input === 0) {
        switch (input) {
          case username:
            document.getElementById("usernameErr").innerHTML =
            "&nbsp Username is required. &nbsp";
          case fname:
            document.getElementById("fnameErr").innerHTML =
            "&nbsp First Name is required. &nbsp";
          case lname:
            document.getElementById("lnameErr").innerHTML =
            "&nbsp Last Name is required. &nbsp";
          case phone:
            document.getElementById("phoneErr").innerHTML =
            "&nbsp Phone Number is Required. &nbsp";
          case email:
            document.getElementById("emailErr").innerHTML =
            "&nbsp Email is required. &nbsp";
          case password:
            document.getElementById("passwordErr").innerHTML =
            "&nbsp Password is required. &nbsp";
          default:
            console.log("Form isn't empty but should work");
        }
      }
    });
  }

  function emptyCheckerAddCar() {
    //  checks for empty values (before regex checking)
    //  year excluded as it it already checked in validateAddCarForm()
    let make = document.forms["addCar"]["make"].value;
    let model = document.forms["addCar"]["model"].value;
    let mileage = Number(document.forms["addCar"]["mileage"].value);
    let color = document.forms["addCar"]["color"].value;
    let asking_price = Number(document.forms["addCar"]["asking_price"].value);

    //  stores inputs as array, foreach loop feeds inputs into a switch when entries are empty or null and returns appropraite messages to the HTML error message spans
    let inputs = [make, model, mileage, color, asking_price];
    inputs.forEach((input) => {
      if (input === "" || input === 0) {
        switch (input) {
          case make:
            document.getElementById("makeErr").innerHTML =
            "&nbsp Make is required &nbsp";
          case model:
            document.getElementById("modelErr").innerHTML =
            "&nbsp Model is required &nbsp";
          case mileage:
            document.getElementById("mileageErr").innerHTML =
            "&nbsp Mileage is required &nbsp";
          case color:
            document.getElementById("colorErr").innerHTML =
            "&nbsp Color is required &nbsp";
          case asking_price:
            document.getElementById("askPriceErr").innerHTML =
            "&nbsp Asking price is required &nbsp";
          default:
            console.log("Form isn't empty");
        }
      }
    });
  }
}
