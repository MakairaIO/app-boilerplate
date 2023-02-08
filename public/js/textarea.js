document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".textarea-input").forEach((el) => {
        const counter = el.querySelector('.textarea-input__count > span');
        if(counter) {
            const textarea = el.querySelector('textarea');
            counter.innerText = textarea.value.length;
            textarea.addEventListener('keyup', (e) => {
                counter.innerText = e.target.value.length;
            })
        }
    })
})
