import * as fdata from "../data/form-data.js"
import regData from "../data/lib/json-nama-daerah-indonesia/regions.json" assert { type: 'json' }
import { DropDownSettings } from "./special-form.js"

const inptext = document.querySelectorAll(".inp-text");
// const inpOtp = document.querySelector(".inp-six-dig").children;

const keycodes = {
    "backspace" : 8,
    "right" : 39,
    "left" : 37
}

let tbDrop = false;

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

function otpValidation() {
    const otpValue = document.getElementById("fullcode");
    const submitBtn = document.getElementById("sub-nito-btn");
    const errorField = document.querySelector(".error-text");

    if (otpValue.value.length < 6) {
        errorField.innerHTML = "Mohon lengkapi kode otp terlebih dahulu";
    }
    else {
        submitBtn.type = "submit";
    }
}

// fungsi untuk navigasi input kode otp
function otpInput() {
    for (let i = 0; i < inpOtp.length; i++) {
        inpOtp[i].addEventListener('input', () => {
            inpOtp[i].value = inpOtp[i].value.length > inpOtp[i].maxLength ? inpOtp[i].value.slice(0, inpOtp[i].maxLength) : inpOtp[i].value;

            let fullcode = "";

            for (let c of inpOtp) {
                fullcode += c.value;
            }

            document.getElementById("fullcode").value = fullcode;
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

function passwordValidation() {
    const password1 = document.getElementById("npw");
    const password2 = document.getElementById("cpw");

    const errorField = document.querySelector(".error-text");

    password1.addEventListener("input", () => {
        errorField.innerHTML = password1.value.length < 8 ? "Buat password setidaknya terdiri dari 8 karakter" : "";
    });

    password2.addEventListener("input", () => {
        errorField.innerHTML = password1.value != password2.value ? "Kedua password yang diisi tidak sama" : "";
    });

}

function inputRequired() {
    const errorInput = document.querySelectorAll(".error-input");

    for (let i = 0; i < inptext.length; i++) {
        if (inptext[i].children[1].required == true && inptext[i].children[1].value.length < 1) {
            inptext[i].children[1].addEventListener("focusout", () => { errorInput[i].innerHTML = "Bidang ini harus diisi*"; });
        }
        else {
            inptext[i].children[1].addEventListener("focusout", () => { errorInput[i].innerHTML = ""; });
        }
    }
}

function createAccountValidation() {
    const submitBtn = document.getElementById("sub-nito-btn");
    
    const password1 = document.getElementById("npw");
    const password2 = document.getElementById("cpw");

    const errorInput = document.querySelectorAll(".error-input");
    const errorField = document.querySelector(".error-text");

    let succesed = true;

    for (let i = 0; i < inptext.length; i++) {
        if (inptext[i].children[1].required == true) {
            if (inptext[i].children[1].value.length < 1) {
                errorInput[i].innerHTML = "Bidang ini harus diisi*";
                succesed = false;
            }
            if (password1.value.length < 8) {
                errorField.innerHTML = "Buat password setidaknya terdiri dari 8 karakter";
                succesed = false;
            }
            if (password1.value != password2.value) {
                errorField.innerHTML = "Kedua password yang diisi tidak sama";
                succesed = false;
            }
        }
    }

    submitBtn.type = succesed == true ? "submit" : "button";
}

function createBusinessValidation() {
    const submitBtn = document.getElementById("sub-nito-btn");

    const inpDropdown = document.querySelectorAll(".inp-dropdown");

    const errorInput = document.querySelectorAll(".error-input");
    const errorDpINput = document.querySelectorAll(".error-dp-input");

    let succesed = true;

    for (let i = 0; i < inptext.length; i++) {
        if (inptext[i].children[1].required == true) {
            if (inptext[i].children[1].value.length < 1) {
                errorInput[i].innerHTML = "Bidang ini harus diisi*";
                succesed = false;
            }
        }
    }

    for (let i = 0; i < inpDropdown.length; i++) {
        if (inpDropdown[i].children[0].required == true) {
            if (inpDropdown[i].children[0].value.length < 1) {
                errorDpINput[i].innerHTML = "Bidang ini harus diisi*";

                succesed = false;
            }
        }
    }

    submitBtn.type = succesed == true ? "submit" : "button";
}

function BusinessInput() {
    let profData = [];
    let citData = [];

    for (let i of regData) {
        profData.push(i.provinsi);
    }

    const bdrop = document.querySelector("#bdrop");
    const pdrop = document.querySelector("#pdrop");
    const cdrop = document.querySelector("#cdrop");

    const bDropDown = new DropDownSettings(bdrop, fdata.registerForm.businessType);
    const pDropDown = new DropDownSettings(pdrop, profData);
    const cDropDown = new DropDownSettings(cdrop, citData);

    bDropDown.addDropDown();
    pDropDown.addDropDown();
    cDropDown.addDropDown();

    for (let i = 0; i < pDropDown.row.length; i++) {
        pDropDown.row[i].addEventListener('click', () => {
            citData = regData[i].kota;

            if (cdrop.disabled == true) {
                cdrop.disabled = false;
                cDropDown.text.innerHTML = "Kota*";
            }

            cDropDown.data = citData;
            cDropDown.refreshDropDown();
        });
    }
}

$(document).ready(() => {
    const submitBtn = document.getElementById("sub-nito-btn");

    // checkInput();
    for (let i = 0; i < inptext.length; i++) {
        inptext[i].children[1].addEventListener("focusin", () => { inptext[i].children[0].style.width = "100%"; });
        inptext[i].children[1].addEventListener("focusout", () => { inptext[i].children[0].style.width = "0%"; });
        inptext[i].children[1].addEventListener("input", () => { checkInput(); });
    }

    if (document.getElementById("otp-form")) {
        inpOtp[0].focus();
        otpInput();

        submitBtn.addEventListener("click", otpValidation);
    }
    else if (document.getElementById("ca-form")) {
        passwordValidation();
        inputRequired();

        for (let i = 0; i < inptext.length; i++) {
            inptext[i].children[1].addEventListener("input", () => { inputRequired(); });
        }

        submitBtn.addEventListener("click", createAccountValidation);
    }
    else if (document.getElementById("bs-form")) {
        const inpDropdown = document.querySelectorAll(".inp-dropdown");
        const errorDpINput = document.querySelectorAll(".error-dp-input");

        BusinessInput();
        inputRequired();

        for (let i = 0; i < inptext.length; i++) {
            inptext[i].children[1].addEventListener("input", () => { inputRequired(); });
        }

        for (let i = 0; i < inpDropdown.length; i++) {
            inpDropdown[i].addEventListener("click", () => {
                if (inpDropdown[i].children[0].value.length > 0) {
                    errorDpINput[i].innerHTML = "";
                }
            });
        }

        submitBtn.addEventListener("click", createBusinessValidation);
    }
});