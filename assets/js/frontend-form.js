document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.storz-public-form[data-multistep="1"]').forEach(function (form) {
    const steps = Array.from(form.querySelectorAll('.storz-form-step'));
    const dots = Array.from(form.querySelectorAll('.storz-form-progress-dot'));
    const indicator = form.querySelector('.storz-step-indicator');
    let current = 0;

    if (!steps.length) {
      return;
    }

    function showStep(index) {
      current = Math.max(0, Math.min(index, steps.length - 1));
      steps.forEach(function (step, i) {
        step.classList.toggle('is-active', i === current);
      });
      dots.forEach(function (dot, i) {
        dot.classList.toggle('is-active', i === current);
      });
      if (indicator) {
        indicator.textContent = 'Step ' + (current + 1) + ' of ' + steps.length;
      }
    }

    form.querySelectorAll('[data-storz-next]').forEach(function (button) {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        showStep(current + 1);
      });
    });

    form.querySelectorAll('[data-storz-prev]').forEach(function (button) {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        showStep(current - 1);
      });
    });

    showStep(0);
  });
});
