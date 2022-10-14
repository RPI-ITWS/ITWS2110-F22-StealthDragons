function togglePassword() {
    let x = document.getElementById("password-input");
    let iconToggle = document.querySelector("#toggle-password")
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
    iconToggle.classList.toggle("bi-eye");
}  