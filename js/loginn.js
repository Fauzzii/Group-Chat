// Fungsi untuk validasi input
function validation() {
    var id = document.f1.user.value;
    var ps = document.f1.pass.value;
    if (id.length == 0 || ps.length == 0) {
        alert("Isi Terlebih Dahulu");
        return false;
    } else {
        if (id.length == 0) {
            alert("Isi Email Terlebih Dahulu");
            return false;
        }
        if (ps.length == 0) {
            alert("Isi Password Terlebih dahulu");
            return false;
        }
    }
}

let eye = document.getElementById("eye");
let pass = document.getElementById("pass");

eye.onclick = function () {
    if (pass.type === "password") {
        pass.type = "text";
        eye.src = "../images/visible.png";
    } else {
        pass.type = "password";
        eye.src = "../images/hide.png";
    }
};


document.getElementById("user").addEventListener("input", function() {
    var emailInput = this.value;
    var emailError = document.getElementById("emailError");
    if (!emailInput.includes("@")) {
        emailError.style.display = "inline-block";
    } else {
        emailError.style.display = "none";
    }
});

// Tambahkan event handler untuk menghilangkan pesan kesalahan saat input kosong
document.getElementById("user").addEventListener("blur", function() {
    var emailInput = this.value;
    var emailError = document.getElementById("emailError");
    if (emailInput.trim() === "") {
        emailError.style.display = "none";
    }
});