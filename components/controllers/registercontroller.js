import registerModel from "../models/registermodel.js";

export default class registerController {
    constructor() {
        this.model = new registerModel();
    }

    async handleRegister(firstName, preposition, Lastname, email, phonenumber, password) {
        try {
            const response = await this.model.register(firstName, preposition, Lastname, email, phonenumber, password);
            console.log("Register succesfull", response);
           // window.location.hash = "/2fa"; 
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "Register failed!";
            console.log("hi");
        }
    }
}
