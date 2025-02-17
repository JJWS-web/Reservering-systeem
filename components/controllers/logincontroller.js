import LoginModel from "../models/loginmodel.js";

export default class loginController {
    constructor() {
        this.model = new LoginModel();
    }

    async handleLogin(username, password) {
        try {
            const response = await this.model.login(username, password);
            console.log("Login successful", response);
            window.location.hash = "/2fa"; // Redirect to another page
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "Login failed!";
        }
    }
}
