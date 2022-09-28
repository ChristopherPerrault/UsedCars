"use strict";

function validateUserRegForm() {
  let fname = document.forms["registration"]["fname"].value;
  if (fname === "" || typeof fname !== "string") {
    alert("First name must be filled out");
    return false;
  }
}
