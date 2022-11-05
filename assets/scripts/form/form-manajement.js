const inptext = document.querySelectorAll(".inp-text");
const inpOtp = document.querySelector(".inp-six-dig").children;

const keycodes = {
    "backspace" : 8,
    "right" : 39,
    "left" : 37
}

const nums = Array.from(Array(10).keys());

// Fungsi yang mendeteksi masukan input apakah kosong atau tidak
function checkInput() {
    let filled = true;

    for (let i = 0; i < inptext.length; i++) {
        if (inptext[i].children[1].value.length == "") {
            filled = false;
            break;
        }
    }

    if (filled == true) {
        console.log("filled!");

        $('#sub-btn').attr("type", "submit");

        $('#sub-btn').css("background-color", "#6C4AB6");
        $('#sub-btn').css("border", "2px solid #6C4AB6");
        $('#sub-btn').css("cursor", "pointer");

        $('#sub-btn').hover(() => {
                $('#sub-btn').css("background-color", "transparent");
                $('#sub-btn').css("color", "#6C4AB6");
                $('#sub-btn').css("border", "2px solid #6C4AB6");
                $('#sub-btn').css("cursor", "pointer");
            }, () => {
                $('#sub-btn').css("background-color", "#6C4AB6");
                $('#sub-btn').css("color", "white");
                $('#sub-btn').css("border", "2px solid #6C4AB6");
                $('#sub-btn').css("cursor", "not-allowed");
            }
        );
    }
    else if (filled == false) {
        $('#sub-btn').attr("type", "button");

        $('#sub-btn').css("background-color", "grey");
        $('#sub-btn').css("border", "2px solid grey");
        $('#sub-btn').css("cursor", "not-alowed");

        $('#sub-btn').hover(() => {
                $('#sub-btn').css("background-color", "grey");
                $('#sub-btn').css("border", "2px solid grey");
                $('#sub-btn').css("cursor", "not-alowed");
                $('#sub-btn').css("color", "white");
            }, () => {
                $('#sub-btn').css("background-color", "grey");
                $('#sub-btn').css("border", "2px solid grey");
                $('#sub-btn').css("cursor", "not-alowed");
                $('#sub-btn').css("color", "white");
            }
        );
    }

}

function otpInput() {
    for (let i = 0; i < inpOtp.length; i++) {
        inpOtp[i].addEventListener('input', () => {
            inpOtp[i].value = inpOtp[i].value.length > inpOtp[i].maxLength ? inpOtp[i].value.slice(0, inpOtp[i].maxLength) : inpOtp[i].value;
        });
        inpOtp[i].addEventListener('keyup', (ev) => {
            if (i < inpOtp.length - 1 && ev.keyCode != keycodes.backspace) {
                for (let b = 0; b < nums.length; b++) { 
                    if (parseInt(ev.key) === nums[b] && inpOtp[i].value != '') {
                        inpOtp[i+1].focus();
                        break;
                    }
                }
            }
            else if (i > 0 && ev.keyCode === keycodes.backspace) {
                inpOtp[i-1].focus();
            }
        });
        
        inpOtp[i].addEventListener('keydown', (ev) => {
            if (i < inpOtp.length - 1 && ev.keyCode === keycodes.right) {
                inpOtp[i+1].focus();
            }
            else if (i > 0 && ev.keyCode === keycodes.left) {
                inpOtp[i-1].focus();
            }
        });

        inpOtp[i].addEventListener('focusin', () => { inpOtp[i].style.transform = "scale(1.1)" });
        inpOtp[i].addEventListener('focusout', () => { inpOtp[i].style.transform = "scale(1)" });
    }
}

$(document).ready(() => {
    checkInput();
    for (let i = 0; i < inptext.length; i++) {
        inptext[i].children[1].addEventListener("focusin", () => { inptext[i].children[0].style.width = "100%"; });
        inptext[i].children[1].addEventListener("focusout", () => { inptext[i].children[0].style.width = "0%"; });
        inptext[i].children[1].addEventListener("input", () => { checkInput(); });
    }

    inpOtp[0].focus();
    otpInput();
});