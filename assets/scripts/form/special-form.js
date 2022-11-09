export class DropDown {
    constructor (target, dbname, name) {
        this.target = target;
        this.dbname = dbname;
        this.name = name;
    }

    AddDropDown() {

    }
}

export class DropDownSettings {
    drop = document.querySelector('.inp-dp-clt');

    constructor (element, data) {
        this.element = element;
        this.data = data;

        this.output = element.children[0];
        this.text = element.children[1];
        this.arrow = element.children[2].children[0];
        this.cont = element.children[3];
        this.row = this.cont.children;

        this.stats = false;
    }

    drowContHTML(d) {
        let outInner = "";

        d.forEach((it) => {
            outInner += "<button class=\"inp-dp-row\" type=\"button\" value=\""+it+"\">"+it+"</button>";
        });

        return outInner;
    }

    dropIn() {
        if (this.stats == false) {
            this.cont.style.height = "300%";
            this.arrow.style.transform =  "rotateZ(180deg)";

            setTimeout(() => {
                document.addEventListener('click', this.dropOut)
            }, 1);

            this.stats = true;
        }
    }

    dropOut() {
        if (this.stats == true) {
            this.cont.style.height = "0%";
            this.arrow.style.transform = "rotateZ(0deg)";

            this.stats = false;

            document.removeEventListener('click', this.dropOut);
        }
    }

    selectRow() {
        for (let it = 0; it < this.row.length; it++) {
            this.row[it].addEventListener('click', () => {
                this.text.innerHTML = this.row[it].value;
                this.output.value = this.row[it].value;
            });
        }
    }

    addDropDown() {

        this.cont.innerHTML = this.data.length > 0 ? this.drowContHTML(this.data) : this.cont.innerHTML;
        this.element.addEventListener('click', () => { return this.stats == false ? this.dropIn() : this.dropOut() });
        this.selectRow();

    }

    refreshDropDown() {
        this.cont.innerHTML = this.drowContHTML(this.data);
        this.selectRow();
    }
}