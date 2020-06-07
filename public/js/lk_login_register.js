
function click_password() {
    let password=  document.getElementById("password");
    let eye= document.getElementById("button-show-pasword");
    if(password.type=="password"){
        password.type="text";
        eye.className="pt-button-eye-close";
    }else{
        password.type="password";
        eye.className="pt-button-eye-open";
    }
}



function password_confirmation() {
    let password=  document.getElementById("password_confirmation");
    let eye= document.getElementById("button-show-pasword-confirmation");
    if(password.type=="password"){
        password.type="text";
        eye.className="pt-button-eye-close";
    }else{
        password.type="password";
        eye.className="pt-button-eye-open";
    }
}