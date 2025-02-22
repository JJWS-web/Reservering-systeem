import registerModel from "../models/registermodel.js";

export default class registerController {
      /**
     * the constructor initializes a new instance of the register
     * model and assigns it to the model property of the register controller
     */
    constructor() {
        this.model = new registerModel();
    }

      /**
     * this function takes in the parameters as you can see below and sends it to the register model
     * to be validated and inserted into the database
     */
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
