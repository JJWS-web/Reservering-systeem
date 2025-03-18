import loginModel from "../models/loginmodel.js";
import twoFactorAuthModel from "../models/2famodel.js";
  /**
     *Initializes a new instance of the login controller and assigns it to the controller property of the login class
     */
export default class loginController {
    constructor() {
        this.model = new loginModel();
        this.twoFactorAuth = new twoFactorAuthModel();
    }

      /**
     * this function takes in the mail and password of the user
     * and sends it to the login model to be validated
     */
    async handleLogin(mail, password) {
        try {
            const response = await this.model.login(mail, password);
            
            if (response.success) {
                console.log("Login successful", response);
                await this.twoFactorAuth.generateAndSend2FACode(mail);
                window.location.hash = "/2fa"; 
            } else {
                document.querySelector("#errorMessage").textContent = response.message || "Login failed!";
            }
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "An error occurred!";
            console.error("Login error:", error);
        }
    }
    
     
}
