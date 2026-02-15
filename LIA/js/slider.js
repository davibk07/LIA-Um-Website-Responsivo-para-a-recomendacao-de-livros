const slider = document.getElementById("slider");
const valor = document.getElementById("valorSlider");

slider.addEventListener("input", function() 
{
    valor.textContent = slider.value;
});