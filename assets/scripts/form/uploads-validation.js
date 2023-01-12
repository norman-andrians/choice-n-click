export class UploadProfile {
    display;

    constructor(imagefile) {
        this.imagefile = imagefile;
    }

    validateImage(max) {
        const reader = new FileReader();
        let errorMsg = "";

        reader.onload = (e) => {
            const img = new Image();

            img.src = e.target.result;
            img.onload = () => {
                const size = this.imagefile.size;

                const width = img.width;
                const height = img.height;

                if (size > max) {
                    errorMsg = "File harus lebih besar dari " + (max / 1000000) + "MB";
                    return false;
                }
                if (width !== height) {
                    errorMsg += "File harus memiliki rasio 1:1 atau ukuran panjang dan lebar yang sama";
                    return false;
                }

                this.display = URL.createObjectURL(e.target.files[0]);
            }
        }

        reader.readAsDataURL(this.imagefile);

        return errorMsg;
    }

    displayImage() {
        if (this.display) {
            return this.display;
        }
        else {
            console.error("Uncaught UploadProfile.displayImage(): there are still no files selected to display");
        }
    }
}