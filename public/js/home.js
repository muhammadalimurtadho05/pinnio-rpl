function switchTab(el, tab) {
  document
    .querySelectorAll(".pin-tab")
    .forEach((t) => t.classList.remove("active"));
  el.classList.add("active");
}
