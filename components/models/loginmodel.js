export default class LoginModel {
      /**
     * sets the twoFACode property to null
     */
    constructor() {
        this.twoFACode = null; 
    }

          /**
     * the login method sends a post request to the backend with
     * the mail and password as parameters. It return the response
     * from the backend.
     */
    async login(mail, password) {
        console.log("Sending login request to backend...");
        console.log("Payload:", { mail, password });

        try {
            const response = await fetch("http://localhost:8000/api/index.php", {// PS did not have enough time to use the proper file for this so index it is but it still works
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ mail, password })
            });

            console.log("Response Status:", response.status);
            console.log("Response Headers:", response.headers);

            if (!response.ok) {
                throw new Error(`Login request failed: ${response.status} ${response.statusText}`);
            }

            const text = await response.text();
            console.log("🔍 Raw Response:", text);
            const data = JSON.parse(text);
                
            return data;
        } catch (error) {
            console.error(" Login Error:", error);
            throw error;
        }
    }
   
    
  /**
     * Generates a 4-digit 2FA code and stores it in the session storage and logs the generated code to the console
     */
    generate2FACode() {
        this.twoFACode = String(Math.floor(Math.random() * 10000)).padStart(4, '0');
        sessionStorage.setItem("twoFACode", this.twoFACode); 
        console.log("Generated 2FA Code:", this.twoFACode);
        return this.twoFACode;
    }
      /**
     * validates the enterd 2fa code with the generated 2fa code
     * and returns a message based on the result
     */
    async validate2FACode(enteredCode) {
        this.twoFACode = sessionStorage.getItem("twoFACode"); 
    
        if (!this.twoFACode) {
            return { success: false, message: "No 2FA code was generated!" };
        }
    
        if (enteredCode === this.twoFACode) {
            sessionStorage.removeItem("twoFACode");
            return { success: true, message: "2FA code is correct!" };
        } else {
            return { success: false, message: "Invalid 2FA code!" };
        }
    }
    
}

