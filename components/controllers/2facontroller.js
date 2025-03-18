import twoFactorAuthModel from "../models/2famodel.js";

export default class twoFactorAuthController {
       
        constructor() {
            this.model = new twoFactorAuthModel();
        }  

         /**
     * this functions takes the entered 2fa code and sends it to the 2fa model to be validated
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