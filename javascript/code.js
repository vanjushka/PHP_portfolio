document.addEventListener("DOMContentLoaded", async function () {

  // Select key elements
  const sliderContainer = document.querySelector(".portfolio-container");
  const sliderIndicator = document.querySelector(".slider-indicator");
  const sliderBar = document.querySelector(".slider-bar");

  let projects = []; // Stores portfolio projects
  let currentIndex = 0; // Tracks the active project index
  let isDragging = false; // Dragging state
  let startX, indicatorLeft, autoSlideFrame;
  let lastTimestamp = 0;
  let dragTimeout;

  // Fetch and Load Portfolio Projects
  try {
      const response = await fetch("portfolio.json");
      projects = await response.json();
      initSlider();
  } catch (error) {
      console.error("Error loading portfolio data:", error);
  }

  function initSlider() {
      displaySlide(currentIndex);
      startAutoSlide();

      // Stop auto-slide when hovering
      sliderContainer.addEventListener("mouseenter", stopAutoSlide);
      sliderContainer.addEventListener("mouseleave", startAutoSlide);

      // Dragging events for manual slider control
      sliderIndicator.addEventListener("mousedown", startDrag);
      sliderIndicator.addEventListener("touchstart", startDrag);
      document.addEventListener("mousemove", drag);
      document.addEventListener("touchmove", drag);
      document.addEventListener("mouseup", endDrag);
      document.addEventListener("touchend", endDrag);

      // Swipe gestures for mobile users
      sliderContainer.addEventListener("touchstart", handleTouchStart, { passive: true });
      sliderContainer.addEventListener("touchmove", handleTouchMove, { passive: true });
      sliderContainer.addEventListener("touchend", handleTouchEnd);
  }


  function displaySlide(index) {
    const slide = document.createElement("div");
    slide.classList.add("slide");

    const { image, title, description, link } = projects[index];

    slide.innerHTML = `
        <div class="slide-content">
            <div class="slide-meta">
                <span class="slide-number">${String(index + 1).padStart(2, '0')}</span>
                <span class="slide-role">UI/UX Designer</span>
            </div>
            
            <img src="${image}" alt="${title}" class="project-image">
            
            <div class="text-overlay">
                <h2>${title}</h2>
                <p>${description.substring(0, 150)}...</p>
                <a href="${link}" target="_blank" class="btn">View Project</a>
            </div>
        </div>
    `;

    sliderContainer.innerHTML = "";
    sliderContainer.appendChild(slide);

    // Only apply slide animation if screen width is less than 768px
    if (window.innerWidth < 768) {
        slide.style.transform = "translateX(100%)"; // Start position (off-screen)
        requestAnimationFrame(() => {
            slide.style.transition = "transform 0.5s ease-out";
            slide.style.transform = "translateX(0)"; // Slide in effect
        });
    }
}



  function changeSlide(step) {
      currentIndex = (currentIndex + step + projects.length) % projects.length;
      updateIndicator();
      displaySlide(currentIndex);
  }

 
  function autoSlideStep(timestamp) {
      if (timestamp - lastTimestamp > 3000) {
          changeSlide(1);
          lastTimestamp = timestamp;
      }
      autoSlideFrame = requestAnimationFrame(autoSlideStep);
  }


  function startAutoSlide() {
      stopAutoSlide();
      autoSlideFrame = requestAnimationFrame(autoSlideStep);
  }

 
  function stopAutoSlide() {
      cancelAnimationFrame(autoSlideFrame);
  }

 
  function updateIndicator() {
      if (!sliderIndicator || projects.length <= 1) return;

      const percentage = (currentIndex / (projects.length - 1)) * 100;
      const barWidth = sliderBar.offsetWidth;
      const indicatorWidth = sliderIndicator.offsetWidth;

      sliderIndicator.style.left = `${(percentage / 100) * (barWidth - indicatorWidth)}px`;
  }


  function startDrag(event) {
      isDragging = true;
      startX = event.clientX || event.touches[0].clientX;
      indicatorLeft = parseFloat(getComputedStyle(sliderIndicator).left);
      stopAutoSlide();
  }


  function drag(event) {
      if (!isDragging) return;

      clearTimeout(dragTimeout);
      dragTimeout = setTimeout(() => {
          const clientX = event.clientX || event.touches[0].clientX;
          const deltaX = clientX - startX;
          const barWidth = sliderBar.offsetWidth;
          const indicatorWidth = sliderIndicator.offsetWidth;
          let newLeft = Math.max(0, Math.min(indicatorLeft + deltaX, barWidth - indicatorWidth));

          sliderIndicator.style.left = `${newLeft}px`;

          const newIndex = Math.round((newLeft / (barWidth - indicatorWidth)) * (projects.length - 1));
          if (newIndex !== currentIndex) {
              currentIndex = newIndex;
              displaySlide(currentIndex);
          }
      }, 16);
  }


  function endDrag() {
      isDragging = false;
      startAutoSlide();
  }


  let touchStartX = 0;
  let touchEndX = 0;
  const swipeThreshold = 50; // Minimum distance for swipe detection

  function handleTouchStart(event) {
      touchStartX = event.touches[0].clientX;
  }

  function handleTouchMove(event) {
      touchEndX = event.touches[0].clientX;
  }

  function handleTouchEnd() {
      let swipeDistance = touchEndX - touchStartX;

      if (Math.abs(swipeDistance) > swipeThreshold) {
          if (swipeDistance < 0) {
              changeSlide(1); // Swipe left → Next slide
          } else {
              changeSlide(-1); // Swipe right → Previous slide
          }
      }
  }
});
