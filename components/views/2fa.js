import loginController from "../controllers/logincontroller.js";

export default class TwoFactorAuth {
      /**
     * intializes a new instance of the login controller and assings it to the controller property of the login class
     */ 
    constructor() {
        this.controller = new loginController();
    }

      /**
     * sets up the event listeners for the 2fa form
     */
    bind() {
        const form = document.querySelector("#Form");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            const code = [
                document.querySelector("#digit1").value,
                document.querySelector("#digit2").value,
                document.querySelector("#digit3").value,
                document.querySelector("#digit4").value
            ].join('');
            this.controller.handleTwoFactorAuth(code);
        });
    }

      /**
     * renders the 2fa form and returns it as a string so it can be renderderdd
     */
    render() {
        return `
            <div>
                <h2>Two-Factor Authentication</h2>
                <form id="Form">
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