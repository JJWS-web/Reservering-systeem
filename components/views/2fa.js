import loginController from "../controllers/logincontroller.js";

export default class TwoFactorAuth {
    constructor() {
        this.controller = new loginController();
    }

    bind() {
        const form = document.querySelector("#2faForm");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            const code = [
                document.querySelector("#digit1").value,
                document.querySelector("#digit2").value,
                document.querySelector("#digit3").value,
                document.querySelector("#digit4").value
            ].join('');
            this.controller.handle2FA(code);
        });
    }

    render() {
        return `
            <div>
                <h2>Two-Factor Authentication</h2>
                <form id="2faForm">
                    <input type="text" id="digit1" maxlength="1" required />
                    <input type="text" id="digit2" maxlength="1" required />
                    <input type="text" id="digit3" maxlength="1" required />
                    <input type="text" id="digit4" maxlength="1" required />
                    <button type="submit">Verify</button>
                </form>
                <p id="errorMessage"></p>
            </div>
        `;
    }
}