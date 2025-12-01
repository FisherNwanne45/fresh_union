// Mobile menu toggle
document.addEventListener("DOMContentLoaded", function () {
  // Mobile hamburger menu toggle
  const hamburgerMenu = document.getElementById("hamburgerMenu");
  const mobileDropdown = document.getElementById("mobileDropdown");

  if (hamburgerMenu && mobileDropdown) {
    hamburgerMenu.addEventListener("click", function (e) {
      e.stopPropagation();
      mobileDropdown.classList.toggle("active");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function () {
      mobileDropdown.classList.remove("active");
    });

    // Prevent dropdown from closing when clicking inside
    mobileDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }

  // Form validation for transfer and deposit
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      let valid = true;
      const inputs = this.querySelectorAll("input[required]");

      inputs.forEach((input) => {
        if (!input.value.trim()) {
          valid = false;
          input.classList.add("error");
        } else {
          input.classList.remove("error");
        }
      });

      if (!valid) {
        e.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
  });

  // PIN code input auto-focus
  const pinInputs = document.querySelectorAll(".pin-input");
  if (pinInputs.length > 0) {
    pinInputs[0].focus();

    pinInputs.forEach((input, index) => {
      input.addEventListener("input", function () {
        if (this.value.length === 1 && index < pinInputs.length - 1) {
          pinInputs[index + 1].focus();
        }
      });

      input.addEventListener("keydown", function (e) {
        if (e.key === "Backspace" && this.value.length === 0 && index > 0) {
          pinInputs[index - 1].focus();
        }
      });
    });
  }

  // Toggle switches
  const toggleSwitches = document.querySelectorAll(".toggle-switch input");
  toggleSwitches.forEach((toggle) => {
    toggle.addEventListener("change", function () {
      const setting = this.closest(".setting-item");
      if (setting) {
        if (this.checked) {
          setting.classList.add("active");
        } else {
          setting.classList.remove("active");
        }
      }
    });
  });

  // Format currency inputs
  const currencyInputs = document.querySelectorAll('input[type="currency"]');
  currencyInputs.forEach((input) => {
    input.addEventListener("input", function () {
      // Remove non-digit characters
      let value = this.value.replace(/\D/g, "");

      // Format as currency
      if (value) {
        value = parseFloat(value) / 100;
        this.value = value.toLocaleString("en-US", {
          style: "currency",
          currency: "USD",
        });
      } else {
        this.value = "";
      }
    });
  });

  // Prevent form submission on Enter key for PIN inputs
  const pinForms = document.querySelectorAll(".pin-container form");
  pinForms.forEach((form) => {
    form.addEventListener("keydown", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
      }
    });
  });
});
