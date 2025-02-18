// Select the form and input fields
const form = document.querySelector("form");
const inputs = form.querySelectorAll("input, textarea");

// Remove old error messages
function removeErrorMessage(field) {
  const errorMessage = field.parentElement.querySelector(`#error-${field.id}`);
  if (errorMessage) {
    errorMessage.remove();
  }
}

// Display new error messages
function displayErrorMessage(field, message) {
  const error = document.createElement("div");
  error.id = `error-${field.id}`;
  error.style.color = "red";
  error.style.marginTop = "5px";
  error.setAttribute("aria-live", "polite"); // Accessibility!
  error.textContent = message;
  field.parentElement.appendChild(error);
}

// Helper functions
function isEmpty(value) {
  return !value.trim();
}

function isValidEmail(email) {
  return /^\S+@\S+\.\S+$/.test(email);
}

// Validate a single field
function validateField(field) {
  const value = field.value.trim();
  const id = field.id;

  removeErrorMessage(field);

  let isValid = true;
  let message = "";

  switch (id) {
    case "last_name":
    case "first_name":
      if (isEmpty(value)) {
        isValid = false;
        message = "This field cannot be empty.";
      }
      break;

    case "email":
      if (isEmpty(value)) {
        isValid = false;
        message = "Please enter an email address.";
      } else if (!isValidEmail(value)) {
        isValid = false;
        message = "Please enter a valid email address.";
      }
      break;

    case "address":
      if (isEmpty(value)) {
        isValid = false;
        message = "Please enter an address.";
      }
      break;

    case "plz_ort":
      if (isEmpty(value)) {
        isValid = false;
        message = "Please enter a postal code.";
      } else if (!/^\d{4,5}(?:\s+[\w\s]+)?$/.test(value)) {
        isValid = false;
        message = "Please enter a valid postal code.";
      }
      break;

    case "message":
      if (isEmpty(value)) {
        isValid = false;
        message = "The message field cannot be empty.";
      }
      break;
  }

  if (!isValid) {
    displayErrorMessage(field, message);
  }

  return isValid;
}

// Validate all fields before submission
function validateAllFields() {
  let isFormValid = true;
  inputs.forEach((input) => {
    if (!validateField(input)) {
      isFormValid = false;
    }
  });
  return isFormValid;
}

// Event listeners 
inputs.forEach((input) => {
  input.addEventListener("focusout", () => {
    validateField(input);
  });
});

// Handle form submission without alert
form.addEventListener("submit", (event) => {
  if (!validateAllFields()) {
    event.preventDefault(); // Stop form submission if there are errors.
  }
});
