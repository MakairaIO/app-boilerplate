document.addEventListener("DOMContentLoaded", () => {
    const numberComponents = document.querySelectorAll('.number-input');
    numberComponents.forEach((component) => {
        const input = component.querySelector('input[type=number]');
        const decreaseBtn = component.querySelector(".decreaseBtn");
        const increaseBtn = component.querySelector(".increaseBtn");
        const emitEvent = () => {
            const ev = new Event('input');
            input.dispatchEvent(ev);
        }
        decreaseBtn.addEventListener("click", () => {
            input.stepDown();
            emitEvent();
        });
        increaseBtn.addEventListener("click", () =>  {
            input.stepUp();
            emitEvent();
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
                emitEvent();
            }     
        })

        const _max = parseInt(input.max);
        const _min = parseInt(input.min);
        const _val = parseInt(input.value || 0);
        if(_val > _max || _val < _min) {
            input.value = _min;
           setTimeout(emitEvent)
        }
    });
})