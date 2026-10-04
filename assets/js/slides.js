document.addEventListener("keydown", event => {
  // Only activate on single slide pages
  if (!document.body.classList.contains("single-slide")) return;

  // Ignore if user is typing in form controls
  const active = document.activeElement;
  if (active && (active.tagName === "INPUT" || active.tagName === "TEXTAREA" || active.isContentEditable)) {
    return;
  }

  if (event.key === "ArrowRight") {
    const next = document.querySelector('a[rel="next"]');
    if (next) {
      event.preventDefault();
      window.location.href = next.href;
    }
  }

  if (event.key === "ArrowLeft") {
    const prev = document.querySelector('a[rel="prev"]');
    if (prev) {
      event.preventDefault();
      window.location.href = prev.href;
    }
  }
});