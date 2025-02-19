import loginModel from "../models/loginmodel.js";

export default class loginController {
    constructor() {
        this.model = new loginModel();
    }

    async handleLogin(mail, password) {
        try {
            const response = await this.model.login(mail, password);
            console.log("Login successful", response);
           // window.location.hash = "/2fa"; 
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "Login failed!";
            console.log("hi");
        }
    }
}
