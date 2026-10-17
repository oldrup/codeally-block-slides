document.addEventListener("keydown", event => {
  // Only activate on single slide pages
  if (!document.body.classList.contains("single-slide")) return;

  // Let other handlers, such as a lightbox, take priority
  if (event.defaultPrevented) return;

  // Ignore keyboard navigation while a lightbox or modal dialog is open
  if (
    document.body.classList.contains("baguetteBox-open") ||
    document.querySelector('[aria-modal="true"], dialog[open]')
  ) {
    return;
  }

  // Ignore if user is typing in form controls
  const active = document.activeElement;
  if (active && (active.tagName === "INPUT" || active.tagName === "TEXTAREA" || active.isContentEditable)) {
    return;
  }

  const goTo = (selector) => {
    const link = document.querySelector(selector);
    if (link) {
      event.preventDefault();
      link.click();
    }
  };

  // Slide "order" is 'reverse" with 1 being the first slide, 2 being the second etc
  // Therefore this looks odd: 'Right' key will link to the "previous" slide with higher number
  if (event.key === "ArrowLeft")  goTo('a[rel="next"]');
  if (event.key === "ArrowRight") goTo('a[rel="prev"]');
});