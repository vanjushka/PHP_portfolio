document.addEventListener("DOMContentLoaded", function () {
  let tl = gsap.timeline();

  // Existing Logo and Model Animation
  tl.from("#letter-V", { opacity: 0, duration: 2, ease: "power2.out" })
    .from("#letter-D", { opacity: 0, duration: 2, ease: "power2.out" }, "-=0.5")
    .from(".model", { opacity: 0, duration: 1, ease: "power2.out" }, "-=1");

  // GSAP Animation for About Page Images
  if (document.querySelector(".about-images")) {
    gsap.from(".animated-img_img1", { y: -200, opacity: 1, duration: 1, ease: "power2.out", delay: 0.5 });
    gsap.from(".animated-img_img2", { y: -220, opacity: 1, duration: 1, ease: "power2.out", delay: 1 });
    gsap.from(".animated-img_img3", { y: -200, opacity: 1, duration: 1, ease: "power2.out", delay: 1.5 });
  }
});
