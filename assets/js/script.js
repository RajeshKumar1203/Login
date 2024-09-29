// Password verify sign in
function formvalid() {
    var validPass = document.getElementById("pass").value;
  
    if (validPass.length < 6) {
        document.getElementById("vaild-pass").innerHTML = "Password must be at least 6 characters.";
        return false;
    } else {
        document.getElementById("vaild-pass").innerHTML = "";
        return true; 
    }
}

