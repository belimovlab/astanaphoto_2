$(document).ready(function() {
var password = document.getElementById("password")
, confirm_password = document.getElementById("re_password");
function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Пароли не совпадают!");
  } else {
    confirm_password.setCustomValidity('');
  }
}
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
});