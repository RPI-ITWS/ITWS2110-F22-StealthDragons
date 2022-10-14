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

//https://www.youtube.com/watch?v=Y36QpYcnbQY
let thumbnails = document.getElementsByClassName('inactive-thumbnail')

let activeImg = document.getElementsByClassName('active-thumbnail')

for (var i=0; i < thumbnails.length; i++){
    
    thumbnails[i].addEventListener('mouseover', function(){

        if(activeImg.length > 0){
            activeImg[0].classList.remove('active-thumbnail')
        }

        this.classList.add('active-thumbnail')
        document.getElementById('current-img').src = this.src

    })
}