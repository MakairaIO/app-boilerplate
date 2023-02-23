document.addEventListener("DOMContentLoaded", () => {
    const rangeComponents = document.querySelectorAll('.custom-range');
    rangeComponents.forEach((component) => {
        const rangeInput = component.querySelector('input[type=range]');
        const indicatorContainer = component.querySelector('.range-input__indicators');

        const maxValue = parseInt(rangeInput.max);
        const minValue = parseInt(rangeInput.min);
        const numberOfIndicators = maxValue - minValue + 1;
        for(let i = 0; i < numberOfIndicators; i++) {
            const span = document.createElement('span');
            indicatorContainer.appendChild(span)
        }

        const renderRangeUI = (min, max, val) => {
            if(val > max || val < min) {
                return;
            }
            const percent =  (val - min) * 100 / (max - min);
            rangeInput.style.backgroundSize = `calc(${100 - percent}% - 1.2rem) 100%`;
        }

        const handleInputChange = (e) => {
            const max = parseInt(e.target.max);
            const min = parseInt(e.target.min);
            const val = parseInt(e.target.value || 0);
            if(e.target.type === 'number') {
                if(val <= max && val >= min) {
                    rangeInput.value = val;
                    renderRangeUI(min, max, val);
                }
            } else {
                renderRangeUI(min, max, val);
            }
        }
        rangeInput.addEventListener('input', handleInputChange);

        const numberInput = component.querySelector('input[type=number]');
        if (numberInput) {
            numberInput.addEventListener('input', handleInputChange);
        }
    });
})