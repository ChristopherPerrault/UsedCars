"use strict";

//! the problem here is that it blocks the duplicate username PHP error message. Solve or remove checking username?

// -----REGISTRATION.PHP VALIDATION-----
function validateUserRegForm() {
  //  receiving and storing the form entries
  //  NOTE: this method retrieves all entries as strings, so they are cast to type Number where applicable
  let username = document.forms["registration"]["username"].value;
  let fname = document.forms["registration"]["fname"].value;
  let lname = document.forms["registration"]["lname"].value;
  let phone = document.forms["registration"]["phone"].value;
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
    (usernameCheck, namesCheck, phoneCheck, emailCheck, passwordCheck === null)
  ) {
    console.log("Form not submitted");
    // each error span receives a matching error to its PHP counterpart
    document.getElementById("usernameErr").innerHTML =
      "&nbsp Only letters & numbers, minimum 5 characters, maxiumum 20 allowed. &nbsp/";
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
}

// -----ADDCAR.PHP VALIDATION-----

function validateAddCarForm() {
  // emptyChecker();
  //  NOTE: this function is called first so as to not have possible empty-value PHP error messages from being blocked by Javascript. This happens because being client-side, JS runs before server-side PHP, so for example if an input is empty, the "empty" PHP error message will be overwritten by JS regex-check error messages - the result being an empty field on submission will not show the user the correct error.

  //  receiving and storing the form entries
  //  NOTE: this method retrieves all entries as strings, so they are cast to type Number where applicable
  let make = document.forms["addCar"]["make"].value;
  let model = document.forms["addCar"]["model"].value;
  let year = Number(document.forms["addCar"]["year"].value);
  let mileage = Number(document.forms["addCar"]["mileage"].value);
  let color = document.forms["addCar"]["color"].value;
  let asking_price = Number(document.forms["addCar"]["asking_price"].value);

  //! needs a fixin'
  //  checks for empty values (before regex checking)
  let inputs = [make, model, year, mileage, color, asking_price];
  inputs.forEach((input) => {
    if (input === "" || input === 0) {
      switch (input) {
        case make:
          document.getElementById("makeErr").innerHTML = "&nbsp test &nbsp";
        case model:
          document.getElementById("modelErr").innerHTML = "&nbsp test2 &nbsp";
        case year:
          document.getElementById("yearErr").innerHTML = "&nbsp test3 &nbsp";
        case mileage:
          document.getElementById("mileageErr").innerHTML = "&nbsp test4 &nbsp";
        case color:
          document.getElementById("colorErr").innerHTML = "&nbsp test5 &nbsp";
        case asking_price:
          document.getElementById("askPriceErr").innerHTML =
            "&nbsp test6 &nbsp";
        default:
          console.log("Form isn't empty");
      }
    }
  });

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

  //  fetches and stores current year
  const currentYear = new Date().getFullYear();

  if (
    (makeCheck, modelCheck, mileageCheck, colorCheck, askingPriceCheck === null)
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
    //! needs to be within scope because 'Invalid year' now shows up no matter what
  } else if (year < 1930 || year > currentYear || isNaN(year)) {
    document.getElementById("yearErr").innerHTML = "&nbsp Invalid year &nbsp";
    return false;
  } else console.log("Success");

  // function emptyChecker(inputs) {
  //   if (inputs === "" || inputs === 0) {
  //     document.getElementById("makeErr").innerHTML = "&nbsp test &nbsp";
  //   }
  // }
} //end validateAddCarForm()

//----------------------------------------------------------------------

// another nope:
// function validateUserRegForm() {
//  checkValidity must be placed on inputs or selects
//   const regBtn = document.getElementById("userRegSubmitBtn");
//   if (!regBtn.checkValidity()) {
//     document.getElementById("fnameErr").innerHTML = "Invalid entry";
//     console.log("something");
//     regBtn;
//     return false;
//   }
// }

// this actually worked as an "empty fields checker" but messages were overwritten
// function validateUserRegForm() {
//   let username = document.forms["registration"]["username"].value;
// let fname = document.forms["registration"]["fname"].value;
// let lname = document.forms["registration"]["lname"].value;
// let phone = document.forms["registration"]["phone"].value;
// let email = document.forms["registration"]["email"].value;
// let password = document.forms["registration"]["password"].value;
//   let inputs = [username, fname, lname, phone, email, password];
//   for (const input of inputs) {
//     if (input === "" || input === null) {
//       const err = document.getElementsByClassName("error");
//       err.innerHTML = "Field is empty";
//       return false;
//     }
//   }
// }
