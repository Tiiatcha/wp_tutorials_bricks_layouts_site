const screen_size_buttons = document.querySelectorAll(
  ".set-screen-size__button"
);
// var screen_size, aspect_ratio, iframe;

if (screen_size_buttons) {
  screen_size_buttons.forEach(setBtnListener);
}
function setBtnListener(btn) {
  btn.addEventListener("click", () => {
    setIframeStyles(btn);
  });
}
function setIframeStyles(btn) {
  const screen_width = btn.dataset.screenSize;
  const aspect_ratio = btn.dataset.aspectRatio;

  const iframe = document.querySelector("iframe");
  iframe.style.width = screen_width;
  iframe.style.aspectRatio = aspect_ratio;
  set_active_button(btn);
  //iframe.style.aspect-ratio = aspect_ratio;
}
function set_active_button(new_active_button) {
  screen_size_buttons.forEach(function (btn) {
    btn.classList.remove("active_screen_size");
  });
  new_active_button.classList.add("active_screen_size");
}
