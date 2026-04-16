// assets/js/app.js
document.addEventListener('DOMContentLoaded', () => {
  const start = document.querySelector('#start_date');
  const end = document.querySelector('#end_date');
  const today = new Date().toISOString().split('T')[0];
  if(start){ start.setAttribute('min', today); }
  if(end){ end.setAttribute('min', today); }
  if(start && end){
    start.addEventListener('change', () => {
      end.min = start.value || today;
    });
  }
});
