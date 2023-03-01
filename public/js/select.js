document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".select-input").forEach((el) => {
        const input = el.querySelector('.rc-select__input');
        const dropdown = el.querySelector('.rc-select-dropdown');
        const viewportHeight = window.innerHeight;

        const hideDropdown = () => {
            dropdown.classList.remove('show');
            dropdown.classList.remove('show-up');
        }
   
        el.addEventListener('blur', () => {
            setTimeout(hideDropdown, 200);
        })
        
        el.addEventListener('click', () => {
            if(dropdown.classList.contains('show')) {
                hideDropdown()
            } else {
                dropdown.classList.add('show');

                const bottomDistance = viewportHeight - dropdown.getBoundingClientRect().bottom;
                if(bottomDistance < 0) {
                    dropdown.classList.add('show-up');
                } else {
                    dropdown.classList.remove('show-up');
                }
            }
        })

        const items = dropdown.querySelectorAll('.rc-select-dropdown__item');
        items.forEach((itemEl) => {
            itemEl.addEventListener('click', () => {
                input.value = itemEl.dataset.value;
                items.forEach((i) => {
                    i.classList.remove('selected');
                })
                itemEl.classList.add('selected');
          
            })
        })
    })
})
