// user/assets/js/theme-settings.js
(function () {
  "use strict";

  const colorMap = {
    color_1: "#eeeeeeff",
    color_2: "#143b64",
    color_3: "#1EAAE7",
    color_4: "#4527a0",
    color_5: "#c62828",
    color_6: "#283593",
    color_7: "#7356f1",
    color_8: "#3695eb",
    color_9: "#00838f",
    color_10: "#ff8f16",
    color_11: "#6673fd",
    color_12: "#2a2a2a",
    color_13: "#1367c8",
    color_14: "#ed0b4c",
    color_15: "#4cb32b",
  };

  function hexToRgba(hex, opacity) {
    hex = hex.replace(/^#/, "");
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    return `rgba(${r}, ${g}, ${b}, ${opacity})`;
  }

  function adjustColor(hex, percent) {
    hex = hex.replace(/^#/, "");
    let r = parseInt(hex.substr(0, 2), 16);
    let g = parseInt(hex.substr(2, 2), 16);
    let b = parseInt(hex.substr(4, 2), 16);

    r = Math.max(0, Math.min(255, r + percent));
    g = Math.max(0, Math.min(255, g + percent));
    b = Math.max(0, Math.min(255, b + percent));

    const pad = (n) => (n < 16 ? "0" : "") + n.toString(16);
    return `#${pad(r)}${pad(g)}${pad(b)}`;
  }

  function updatePrimaryCss(colorKey) {
    const primaryHex = colorMap[colorKey] || colorMap["color_1"];
    const hoverHex = adjustColor(primaryHex, -30);
    const darkHex = adjustColor(primaryHex, -60);

    document.documentElement.style.setProperty("--primary", primaryHex);
    document.documentElement.style.setProperty("--primary-hover", hoverHex);
    document.documentElement.style.setProperty("--primary-dark", darkHex);

    for (let i = 1; i <= 5; i++) {
      document.documentElement.style.setProperty(
        `--rgba-primary-${i}`,
        hexToRgba(primaryHex, i * 0.1)
      );
    }
  }

  function updateSidebarBg(colorKey) {
    const hex = colorMap[colorKey] || colorMap["color_1"];
    document.documentElement.style.setProperty("--sidebar-bg", hex);
    // Remove sidebar image if any
    document.querySelectorAll(".deznav, .nav-header").forEach((el) => {
      el.style.background = "";
    });
  }

  function updateSidebarText(colorKey) {
    const hex = colorMap[colorKey] || colorMap["color_1"];
    document.documentElement.style.setProperty("--sidebar-text", hex);
  }

  function updateSidebarImage(imgUrl) {
    document.querySelectorAll(".deznav, .nav-header").forEach((el) => {
      el.style.background = `url(${imgUrl})`;
      el.style.backgroundSize = "cover";
    });
    // Optional: set sidebar-bg attribute to 'image'
    document.body.setAttribute("data-sidebarbg", "image");
  }

  document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;

    // Map selects to body data attributes
    const mapping = {
      theme_version: "data-theme-version",
      theme_layout: "data-layout",
      header_position: "data-header-position",
      sidebar_style: "data-sidebar-style",
      sidebar_position: "data-sidebar-position",
      container_layout: "data-container",
      typography: "data-typography",
    };

    Object.keys(mapping).forEach(function (id) {
      const el = document.getElementById(id);
      if (!el) return;
      el.addEventListener("change", function () {
        body.setAttribute(mapping[id], this.value);
      });
    });

    // Radio inputs for colors and images
    const inputs = document.querySelectorAll('input[type="radio"]');
    inputs.forEach(function (input) {
      const name = input.name;
      if (
        ![
          "primary_bg",
          "navigation_header",
          "header_bg",
          "sidebar_bg",
          "sidebar_text",
          "sidebar_img_bg",
        ].includes(name)
      )
        return;

      input.addEventListener("change", function () {
        const v = this.value;
        if (name === "primary_bg") {
          body.setAttribute("data-primary", v);
          updatePrimaryCss(v);
        } else if (name === "navigation_header") {
          body.setAttribute("data-nav-headerbg", v);
        } else if (name === "header_bg") {
          body.setAttribute("data-headerbg", v);
        } else if (name === "sidebar_bg") {
          body.setAttribute("data-sidebarbg", v);
          updateSidebarBg(v);
        } else if (name === "sidebar_text") {
          body.setAttribute("data-sidebartext", v);
          updateSidebarText(v);
        } else if (name === "sidebar_img_bg") {
          updateSidebarImage(v);
        }
      });
    });

    // Initialize primary color from existing attribute
    const currentPrimary = body.getAttribute("data-primary") || "color_1";
    updatePrimaryCss(currentPrimary);

    // Initialize sidebar colors from attributes
    const currentSidebarBg = body.getAttribute("data-sidebarbg");
    if (currentSidebarBg && currentSidebarBg !== "image")
      updateSidebarBg(currentSidebarBg);
    const currentSidebarText = body.getAttribute("data-sidebartext");
    if (currentSidebarText) updateSidebarText(currentSidebarText);

    // If sidebar has an image attribute, apply it (optional)
    const sidebarImage = body.getAttribute("data-sidebar-img");
    if (sidebarImage) updateSidebarImage(sidebarImage);
  });
})();
