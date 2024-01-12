let $driver, $date ,$producer, iradio ;
let $hoursMorning , $hoursAfternoon, $titleMorning, $titleAfternoon;
const titleMorning = `
   En la mañana
`; 
const titleAfternoon = `
   En la tarde
`; 

const noHours = `<h5 class="text-danger">
   No hay horas disponibles
</h5>`;

$(function(){
  $producer = $('#producers');
  $driver = $('#driver');
  $date = $('#date');
  $titleMorning = $('#titleMorning');
  $hoursMorning = $('#hoursMorning');
  $titleAfternoon = $('#titleAfternoon');
  $hoursAfternoon = $('#hoursAfternoon');

  $producer.change(() => {
 const producersID = $producer.val();
 const url = `/api/productoras/${producersID}/conductores`;
 $.getJSON(url, onDriversLoaded);
  });

  $driver.change(loadHours);
  $date.change(loadHours);

});

function onDriversLoaded(drivers){
   let htmlOptions = '';
   drivers.forEach(driver => {
     htmlOptions += `<option value="${driver.id}" >${driver.name}</option>`;
   });
   $driver.html(htmlOptions);
   loadHours();
}

function loadHours(){
    const selectedDate =  $date.val();
    const driverID = $driver.val();
    const url = `/api/horario/horas?date=${selectedDate}&conductor_id=${driverID}`;
    $.getJSON(url, displayHours);
}

function displayHours(data){
    let htmlHoursM = '';
    let htmlHoursA = '';
    iradio = 0;
    if (data.morning) {
        const morning_intervalos = data.morning;
        morning_intervalos.forEach(intervalo => {
            htmlHoursM += getRadioIntervalohtml(intervalo) ;
        });
    }
 
     if (!htmlHoursM != "") {
        htmlHoursM += noHours;
     }
    
    if (data.afternoon) {
        const afternoon_intervalos = data.afternoon;
        afternoon_intervalos.forEach(intervalo => {
            htmlHoursA += getRadioIntervalohtml(intervalo);
        });
    }

    if (!htmlHoursA != "") {
        htmlHoursA += noHours;
     }

    $hoursMorning.html(htmlHoursM);
    $hoursAfternoon.html(htmlHoursA);
    $titleMorning.html(titleMorning);
    $titleAfternoon.html(titleAfternoon);
}

function getRadioIntervalohtml(intervalo){
     const text = `${intervalo.start} - ${intervalo.end}`;
     return `<div class="custom-control custom-radio mb-3">
               <input type="radio" id="interval${iradio}" name="scheduled_time" value="${intervalo.start}" 
               class="custom-control-input" required>
               <label class="custom-control-label" for="interval${iradio++}">${text}</label>
             </div>`;
}