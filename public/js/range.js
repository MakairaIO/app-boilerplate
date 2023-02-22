document.addEventListener("DOMContentLoaded", () => {
    const rangeComponents = document.querySelectorAll('.custom-range');
    rangeComponents.forEach((component) => {
        const rangeInput = component.querySelector('input[type=range]');
        const indicatorContainer = component.querySelector('.range-input__indicators');

        const step = parseInt(rangeInput.step || 1);
        const maxValue = parseInt(rangeInput.max);
        const numberOfIndicators = maxValue / step + 1;
        for(let i = 0; i < numberOfIndicators; i++) {
            const span = document.createElement('span');
            indicatorContainer.appendChild(span)
        }

        const handleInputChange = (e) => {
            const max = parseInt(e.target.max);
            const val = parseInt(e.target.value || 0);
            const percent =  val * 100 / max;
            if(e.target.type === 'number') {
                if(val <= max) {
                    rangeInput.value = val;
                    rangeInput.style.backgroundSize = 100 - percent + '% 100%';
                }
            } else {
                rangeInput.style.backgroundSize = 100 - percent + '% 100%';
            }
        }
        rangeInput.addEventListener('input', handleInputChange);

        const numberInput = component.querySelector('input[type=number]');
        if (numberInput) {
            const decreaseBtn = component.querySelector(".decreaseBtn");
            const increaseBtn = component.querySelector(".increaseBtn");
            decreaseBtn.addEventListener("click", () => {
                numberInput.stepDown();
                const ev = new Event('input');
                numberInput.dispatchEvent(ev);
            });
            increaseBtn.addEventListener("click", () =>  {
                numberInput.stepUp();
                const ev = new Event('input');
                numberInput.dispatchEvent(ev);
            });
            numberInput.addEventListener('input', handleInputChange);
            numberInput.addEventListener('focusin', (e) => {
                e.target.dataset.value = e.target.value;
            });
            numberInput.addEventListener('change', (e) => {
                const prevValue = parseInt(e.target.dataset.value);
                const currentValue = parseInt(e.target.value)
                const maxValue = parseInt(e.target.max);
                if(currentValue > maxValue || currentValue < 0) {
                    numberInput.value = prevValue;
                    const ev = new Event('input');
                    numberInput.dispatchEvent(ev);
                }     
            })
        }
    });
})