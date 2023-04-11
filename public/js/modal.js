const initModal = (id) => {
    const modal = document.querySelector(`.modal__${id}`);
    const overlay = document.querySelector(`.modal-overlay__${id}`);
    const closeModalBtn = document.querySelector(`.modal-close__${id}`);
    const openModalBtn = document.querySelector(`.modal-open__${id}`);

    const openModal = function () {
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
        scrollLock.disablePageScroll()
    };
    
    const closeModal = function () {
      modal.classList.add("hidden");
      overlay.classList.add("hidden");
      scrollLock.enablePageScroll()
    };
    
    closeModalBtn && closeModalBtn.addEventListener("click", closeModal);
    overlay && overlay.addEventListener("click", closeModal);

    openModalBtn && openModalBtn.addEventListener("click", openModal);

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && !modal.classList.contains("hidden")) {
        closeModal();
      }
    });
}

