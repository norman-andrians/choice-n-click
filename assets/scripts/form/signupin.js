const inptext = document.querySelectorAll(".inp-text");

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

$(document).ready(() => {
    checkInput();
    for (let i = 0; i < inptext.length; i++) {
        inptext[i].children[1].addEventListener("focusin", () => { inptext[i].children[0].style.width = "100%"; });
        inptext[i].children[1].addEventListener("focusout", () => { inptext[i].children[0].style.width = "0%"; });
        inptext[i].children[1].addEventListener("input", () => { checkInput(); });
    }
});