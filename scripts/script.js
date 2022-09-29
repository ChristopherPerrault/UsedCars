"use strict";

// function validateUserRegForm() {
//   const username = document.getElementById("username");

//   const form = document.getElementById("regForm");
// }


//! the problem here is that it blocks the duplicate username PHP error message
function validateUserRegForm() {
  let username = document.forms["registration"]["username"].value;
  let fname = document.forms["registration"]["fname"].value;
  let lname = document.forms["registration"]["lname"].value;
  let phone = document.forms["registration"]["phone"].value;
  let email = document.forms["registration"]["email"].value;
  let password = document.forms["registration"]["password"].value;

  const usernameRegex = /^[a-zA-Z0-9]{5,20}$/;
  const namesRegex = /^[a-zA-Z]{2,50}$/;
  const phoneRegex = /^[0-9]{10,11}$/;
  const emailRegex = /([\w\-]+\@[\w\-]+\.[\w\-]+)/;
  const passwordRegex =
    /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$/;

  const usernameCheck = usernameRegex.exec(username);
  const namesCheck = namesRegex.exec(fname, lname);
  const phoneCheck = phoneRegex.exec(phone);
  const emailCheck = emailRegex.exec(email);
  const passwordCheck = passwordRegex.exec(password);

  //  if regex fails via .exec, it returns as null, example:
  // console.log(usernameCheck);
  if (
    (usernameCheck, namesCheck, phoneCheck, emailCheck, passwordCheck === null)
  ) {
    console.log("Form not sumbitted");
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
    // the html form interprets 'false' as to not submit the form
  } else {
    console.log("Success");
  }
}

//----------------------------------------------------------------------

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
