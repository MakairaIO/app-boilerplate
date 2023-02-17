function MultiRangeSlider(element, settings, getFormattedValue = (value) => value) {
    const slider = element;
    const DOM = {};
    let steps = [];
    let dragging = false;
    let currentHandle = null;
    const getHandleOffset = () => 0;
    const getTrackWidth = () => DOM.track.offsetWidth;
    const getFocusedHandle = () => DOM.handles.find(handle => document.activeElement === handle);
    const inputNumber = slider.parentNode.querySelector(".number-input__input");
    const decreaseBtn = slider.parentNode.querySelector(".decreaseBtn");
    const increaseBtn = slider.parentNode.querySelector(".increaseBtn");
  
    const values = {
      start: settings.start,
      end: settings.end,
      initValue: settings.initValue
    };
  
    function getSteps(sliderWidth, stepLen, handleOffset) {
      const steps = [];
      for (let i = 0; i <= stepLen; i++) {
        const stepX = i * (sliderWidth * 1 / stepLen) + handleOffset;
        const stepPercent = (i * (100 / stepLen)).toFixed(2);
        const value = i * settings.increment + settings.start;
        steps.push({
          value,
          stepX,
          stepPercent
        });
      }
      return steps;
    }
  
    const getStepLen = () => (settings.end - settings.start) / settings.increment;
    
    const startDrag = (event) => {
      currentHandle = event.target;
      dragging = true;
      slider.classList.add("dragging");
    };
    const stopDrag = () => {
      dragging = false;
      slider.classList.remove("dragging");
    }
  
    function createLabels(container, settings) {
      const labels = document.createElement("div");
      labels.classList.add("slider-input__labels");
      steps = getSteps(slider.offsetWidth, getStepLen(), getHandleOffset());
      steps.forEach(step => {
        const label = document.createElement("label");
        label.classList.add("label");
        label.style.left = `${step.stepPercent}%`;
        labels.appendChild(label);
        const tick = document.createElement("div");
        tick.classList.add("slider-input__tick");
        container.appendChild(tick);
      });
      
      return labels;
    }
    
    function addElementsToDOM() {
      const track = document.createElement("div");
      track.classList.add("slider-input__track");
      DOM.track = track;
      const trackBg = document.createElement("div");
      trackBg.classList.add("slider-input__track-bg");
      const trackFill = document.createElement("div");
      trackFill.classList.add("slider-input__fill");
      DOM.trackFill = trackFill;
      const ticksContainer = document.createElement("div");
      ticksContainer.classList.add("slider-input__ticks");
      let handleContainer = document.createElement("div");
      handleContainer.classList.add("slider-input__handles");
  
      const rightHandle = document.createElement("div");
      rightHandle.classList.add("slider-input__handle");
      rightHandle.setAttribute("data-handle-position", "end");
      rightHandle.setAttribute("tabindex", 0);
      handleContainer.appendChild(rightHandle);
      DOM.handles = [rightHandle];
      track.appendChild(trackBg);
      track.appendChild(trackFill);
      slider.appendChild(track);
      slider.appendChild(handleContainer);
      const labels = createLabels(ticksContainer, settings);
      slider.appendChild(labels);
      track.appendChild(ticksContainer);
    }
    
    function init() {
      addElementsToDOM();
      DOM.handles.forEach(handle => {
        handle.addEventListener("mousedown", startDrag);
        handle.addEventListener("touchstart", startDrag);
      });
      window.addEventListener("mouseup", stopDrag);
      window.addEventListener("touchend", stopDrag);
      window.addEventListener("resize", onWindowResize);
      window.addEventListener("mousemove", onHandleMove);
      window.addEventListener("touchmove", onHandleMove);
      window.addEventListener("keydown", onKeyDown);

      if (inputNumber) {
        decreaseBtn.addEventListener("click", function() {
          if (1*inputNumber.value > 1*inputNumber.min) {
            inputNumber.value--;
            values['end'] = steps[1*inputNumber.value].value;
            render();
          }
        });
    
        increaseBtn.addEventListener("click", function() {
          if (1*inputNumber.value < 1*inputNumber.max) {
            inputNumber.value++;
            values['end'] = steps[1*inputNumber.value].value;
            render();
          }
        });

        inputNumber.addEventListener("change", function() {
         values['end'] = steps[1*inputNumber.value].value;
         render();
        });
      }

      render();
      innitFill();
      initHandles();
    }
  
    function dispatchEvent() {
      let event;
      if (window.CustomEvent) {
        event = new CustomEvent("slider-change", {
          detail: { start: values.start, end: values.end }
        });
      } else {
        event = document.createEvent("CustomEvent");
        event.initCustomEvent("slider-change", true, true, {
          start: values.start,
          end: values.end
        });
      }
      slider.dispatchEvent(event);
    }
  
    function getClosestStep(newX, handlePosition) {
      const isStart = handlePosition === "start";
      const otherStep = getStep(values[isStart ? "end" : "start"]);

      let closestDistance = Infinity;
      let indexOfClosest = null;
      for (let i = 0; i < steps.length; i++) {
        if (
          (isStart && steps[i].stepX < otherStep.stepX) ||
          (!isStart && steps[i].stepX > otherStep.stepX)
        ) {
          const distance = Math.abs(steps[i].stepX - newX);
          if (distance < closestDistance) {
            closestDistance = distance;
            indexOfClosest = i;
          } else {
            if (indexOfClosest === 1 && i === steps.length - 1 && newX == 0) {
              indexOfClosest = 0
            }
          }
        }
      }
      return steps[indexOfClosest];
    }
  
    function updateHandles() {
      DOM.handles.forEach(function(handle, index) {
        const step =  getStep(values.end);
        handle.style.left = `${step.stepPercent}%`;
      });
    }
  
    const getStep = value => steps.find(step => step.value === value);
  
    function updateFill() {
      const trackWidth = getTrackWidth();
      const startStep = getStep(values.start);
      const endStep = getStep(values.end);

      const newWidth =
        trackWidth - (startStep.stepX + (trackWidth - endStep.stepX));
      const percentage = newWidth / trackWidth * 100;
      DOM.trackFill.style.width = `${percentage}%`;
      DOM.trackFill.style.left = `${startStep.stepPercent}%`;
    }

    function innitFill() {
      const trackWidth = getTrackWidth();
      const startStep = getStep(values.start);
      const endStep = getStep(values.initValue);

      const newWidth =
        trackWidth - (startStep.stepX + (trackWidth - endStep.stepX));
      const percentage = newWidth / trackWidth * 100;
      DOM.trackFill.style.width = `${percentage}%`;
      DOM.trackFill.style.left = `${startStep.stepPercent}%`;
    }

    function initHandles() {
      DOM.handles.forEach(function(handle, index) {
        const step =  getStep(values.initValue);
        handle.style.left = `${step.stepPercent}%`;
      });
    }
  
    function render() {
      slider.offsetWidth
      slider.style.setProperty('--slider-width', slider.offsetWidth + 'px');
      updateFill();
      updateHandles();
    }
  
    function onHandleMove(event) {
      event.preventDefault();
      if (!dragging) return;
      const handleOffset = getHandleOffset();

      const clientX = event.clientX || event.touches[0].clientX;
      window.requestAnimationFrame(() => {
        if (!dragging) return;
        const mouseX = clientX - slider.offsetLeft;
        const handlePosition = currentHandle.dataset.handlePosition;

        let newX = Math.max(
          handleOffset,
          Math.min(mouseX, slider.offsetWidth - handleOffset)
        );

        const currentStep = getClosestStep(newX, handlePosition);
        values[handlePosition] = currentStep.value;
        render();
        dispatchEvent();
        if (inputNumber) {
          inputNumber.value = values.end
        }
      });
    }
    
    function onKeyDown(e) {
      const keyCode = e.keyCode;
      const handle = getFocusedHandle();
      const keys = {
        "37": "left",
        "39": "right"
      };
      const arrowKey = keys[keyCode];
      if(!handle || !arrowKey) return;
      const handlePosition = handle.dataset.handlePosition;
      const stepIncrement = arrowKey === "left" ? -1 : 1;
      const stepIndex = steps.findIndex(step => step.value === values[handlePosition]);
      const newIndex = stepIndex + stepIncrement;
      if(newIndex < 0 || newIndex >= steps.length) return;
      values[handlePosition] = steps[newIndex].value;
      render();
      dispatchEvent();
    }
    
    function onWindowResize() {
      steps = getSteps(slider.offsetWidth, getStepLen(), getHandleOffset());
      render();
    }
  
    function update(newValues) {
      values.start = newValues.start;
      values.end = newValues.end;
      render();
    }
    
    function on(eventType, fn) {
      slider.addEventListener(eventType, fn);
    }
    
    function off(eventType, fn) {
      slider.removeEventListener(eventType, fn);
    }
    
    function destroy(removeElement) {
      DOM.handles.forEach(handle => {
        handle.removeEventListener("mousedown", startDrag);
        handle.removeEventListener("touchstart", startDrag);
      });
      window.removeEventListener("mouseup", stopDrag);
      window.removeEventListener("touchend", stopDrag);
      window.removeEventListener("resize", onWindowResize);
      window.removeEventListener("mousemove", onHandleMove);
      window.removeEventListener("touchmove", onHandleMove);
      window.removeEventListener("keydown", onKeyDown);
      if(removeElement) slider.parentNode.removeChild(slider);
    }
  
    return {
      on,
      off,
      update,
      destroy,
      init
    };
  }
