export default class TwoFactorAuthModel {
    /**
     * Sets the twoFACode property to null
     */
    constructor() {
        this.twoFACode = null;
    }

    /**
     * Generates a 4-digit 2FA code, stores it in session storage,
     * sends only the code to the backend (mail.php),
     * and logs relevant info.
     */
    async generateAndSend2FACode() {
        this.twoFACode = String(Math.floor(Math.random() * 10000)).padStart(4, '0');
        sessionStorage.setItem("twoFACode", this.twoFACode);
        console.log(`[2FA] Generated Code: ${this.twoFACode}`);

        try {
            const response = await fetch("http://localhost:8000/api/mail/mail.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ twoFACode: this.twoFACode })
            });

            console.log(`[2FA] Response Status: ${response.status}`);

            if (!response.ok) {
                throw new Error(`[2FA] Failed to send code: ${response.status} ${response.statusText}`);
            }

            const text = await response.text();
            console.log(`[2FA] Backend Response: ${text}`);
            console.log("[2FA] Code successfully sent to backend");

            return { success: true, message: "2FA code generated and sent successfully!" };
        } catch (error) {
            console.error("[2FA] Error sending code:", error);
            throw error;
        }
    }

    /**
     * Validates the entered 2FA code with the generated one.
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
