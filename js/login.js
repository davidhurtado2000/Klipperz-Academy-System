function showPassword() {
    var x = document.getElementById("password-field");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }