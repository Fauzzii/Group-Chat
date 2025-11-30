// Fungsi untuk validasi input
function validation() {
    var id = document.f1.user.value;
    var ps = document.f1.pass.value;
    var unm = document.f1.username.value;
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
        if (unm.length == 0) {
            alert("Isi Username Terlebih dahulu");
            return false;
        }
    }
}

let eye = document.getElementById("eye");
let pass = document.getElementById("pass");

eye.onclick = function () {
    if (pass.type === "password") {
        pass.type = "text";
        eye.src = "visible.png";
    } else {
        pass.type = "password";
        eye.src = "hide.png";
    }
};
