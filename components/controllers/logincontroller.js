import loginModel from "../models/loginmodel.js";

  /**
     *Initializes a new instance of the login controller and assigns it to the controller property of the login class
     */
export default class loginController {
    constructor() {
        this.model = new loginModel();
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
                this.model.generate2FACode();
                window.location.hash = "/2fa"; 
            } else {
                document.querySelector("#errorMessage").textContent = response.message || "Login failed!";
            }
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "An error occurred!";
            console.error("Login error:", error);
        }
    }
    
      /**
     * this functions takes the entered 2fa code and sends it to the login model to be validated
     */
    async handleTwoFactorAuth(code) {
        try {
            const response = await this.model.validate2FACode(code);

            if (response.success) {
                console.log("2FA succesful", response);
            } else {
                document.querySelector("#errorMessage").textContent = response.message || "2FA failed!";
            }
        } catch (error) {
            document.querySelector("#errorMessage").textContent = "An error occurred!";
            console.error("2FA error:", error);
        }
    }
}
