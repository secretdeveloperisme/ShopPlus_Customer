$(()=>{

});
function toast({title,message,type,duration}){
  const main = document.getElementById("toast");
  var toast = document.createElement("div");
  var icon = {
                success : "fas fa-check-circle",
                error : "fas fa-exclamation-circle",
                warning : "fas fa-exclamation-triangle"
              };
  toast.innerHTML = `
              <div class="toast__icon">
                  <i class="${icon[type]}"></i>
              </div>
              <div class="toast__body">
                  <h2 class="body__title">
                      ${title}
                  </h2>
                  <p class="body__msg">
                      ${message}
                  </p>
              </div>
              <div class="toast__close">
                  &times;
              </div> 
  `; 
  var delay = (duration / 1000).toFixed(2);
  toast.classList.add("toast","toast--"+type);
  toast.style.animation =`slideInLeft 1s linear forwards,fadeOut 1s linear ${delay}s forwards`;
  main.appendChild(toast);

  var t = setTimeout(()=>main.removeChild(toast),duration+1000);
  toast.onclick = function(evt){
      if(evt.target.closest(".toast__close")){
          main.removeChild(toast);
          clearTimeout(t);
      }
  }
};
// base function
function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}