function toggleDark() {
  document.querySelector("body").classList.toggle("dark");
}

/// jquery
$(document).ready(function () {
  $("#toggle-dark").click(function () {
    if (localStorage.getItem("dark-mode") === "true") {
      localStorage.setItem("dark-mode", "false");
    } else {
      localStorage.setItem("dark-mode", "true");
    }
    toggleDark();
  });
});

// manipulasi dom 1 selain dark mode
function hideItem(item) {
  item.parentElement.remove();
}

const text = `"Audiophiles don't use their equipment to listen to your music."`;
const text2 = `"Audiophiles use your music to listen to their equipment."`;
const speed = 50;
let i = 0;
let currentText = text;

// manipulasi dom 2 selain dark mode
const quoteTextElement = document.querySelector(".quote-text");
function typeWriter() {
  const interval = setInterval(() => {
    if (i < currentText.length) {
      quoteTextElement.innerHTML += currentText.charAt(i);
      i++;
    } else {
      clearInterval(interval);
      setTimeout(() => {
        quoteTextElement.innerHTML = "";
        i = 0;
        currentText = currentText === text ? text2 : text; // toggle
        typeWriter();
      }, 2000);
    }
  }, speed);
}
if (quoteTextElement) typeWriter();

const darkMode = localStorage.getItem("dark-mode");
if (darkMode === "true") {
  toggleDark();
}
