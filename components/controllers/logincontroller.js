import loginModel from "../models/loginmodel.js";

export default class loginController {
    constructor() {
        this.model = new loginModel();
    }

    async handleLogin(mail, password) {
        try {
            const response = await this.model.login(mail, password);
            
            if (response.success) {
                console.log("Login successful", response);
                window.location.hash = "/2fa"; 
            } else {
                document.querySelector("#errorMessage").textContent = response.message || "Login failed!";
            }
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "An error occurred!";
            console.error("Login error:", error);
        }
    }
    
    async hanldeTwoFactorAuth() {
        
    }
}
