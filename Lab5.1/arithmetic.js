"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const n1 = document.getElementById("num1");
  const n2 = document.getElementById("num2");
  const op = document.getElementById("operation");
  const out = document.getElementById("result");

  const update = () => {
    const a = Number(n1.value);
    const b = Number(n2.value);
    let r;

    switch (op.value) {
      case "+": r = a + b; break;
      case "-": r = a - b; break;
      case "*": r = a * b; break;
      case "/": r = (b === 0) ? "undefined" : a / b; break;
      case "%": r = (b === 0) ? "undefined" : a % b; break;
    }

    out.value = r;
  };

  // update whenever anything changes
  n1.addEventListener("input", update);
  n2.addEventListener("input", update);
  op.addEventListener("change", update);

  // initial calculation
  update();
});
