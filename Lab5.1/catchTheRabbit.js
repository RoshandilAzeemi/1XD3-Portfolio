"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const rabbits = [
    document.getElementById("rabbit1"),
    document.getElementById("rabbit2"),
    document.getElementById("rabbit3"),
    document.getElementById("rabbit4")
  ];

  const noeggs = document.getElementById("noeggs");
  const slow = document.getElementById("slow");

  let pos = 0;     // which rabbit is visible
  let tries = 0;   // number of mouseovers

  // Initial visibility
  rabbits.forEach((r, i) =>
    r.style.visibility = i === 0 ? "visible" : "hidden"
  );
  noeggs.style.visibility = "hidden";
  slow.style.visibility = "hidden";

  // IMPORTANT: make messages not block mouse events
  noeggs.style.pointerEvents = "none";
  slow.style.pointerEvents = "none";

  // One handler for all rabbits
  rabbits.forEach(rabbit => {
    rabbit.addEventListener("mouseover", () => {
      tries++;

      // Move rabbit right if possible
      if (pos < rabbits.length - 1) {
        rabbits[pos].style.visibility = "hidden";
        pos++;
        rabbits[pos].style.visibility = "visible";
      }

      // Show messages at required counts
      if (tries >= 4) noeggs.style.visibility = "visible";
      if (tries >= 20) slow.style.visibility = "visible";
    });
  });
});
