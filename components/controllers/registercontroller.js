import registerModel from "../models/registermodel.js";

export default class registerController {
    constructor() {
        this.model = new registerModel();
    }

    async handleRegister({ firstname, preposition, lastname, mail, phonenumber, password }) {
        try {
            const response = await this.model.register(firstname, preposition, lastname, mail, phonenumber, password);
            console.log("Register successful", response);
            // window.location.hash = "/2fa"; 
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "Register failed!";
            console.log("hi");
        }
    }
    
    
}
