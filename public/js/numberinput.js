document.addEventListener("DOMContentLoaded", () => {
    const numberComponents = document.querySelectorAll('.number-input');
    numberComponents.forEach((component) => {
        const input = component.querySelector('input[type=number]');
        const decreaseBtn = component.querySelector(".decreaseBtn");
        const increaseBtn = component.querySelector(".increaseBtn");
        decreaseBtn.addEventListener("click", () => {
            input.stepDown();
            const ev = new Event('input');
            input.dispatchEvent(ev);
        });
        increaseBtn.addEventListener("click", () =>  {
            input.stepUp();
            const ev = new Event('input');
            input.dispatchEvent(ev);
        });
        input.addEventListener('focusin', (e) => {
            e.target.dataset.value = e.target.value;
        });
        input.addEventListener('change', (e) => {
            const prevValue = parseInt(e.target.dataset.value);
            const currentValue = parseInt(e.target.value)
            const maxValue = parseInt(e.target.max);
            const minValue = parseInt(e.target.min);
            if(currentValue > maxValue || currentValue < minValue) {
                input.value = prevValue;
                const ev = new Event('input');
                input.dispatchEvent(ev);
            }     
        })
    });
})