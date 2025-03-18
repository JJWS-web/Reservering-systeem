import twoFactorAuthController from "../controllers/2facontroller.js";

export default class TwoFactorAuth {
      /**
     * intializes a new instance of the login controller and assings it to the controller property of the login class
     */ 
    constructor() {
        this.controller = new twoFactorAuthController();
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
           <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #E3EEFF;
    }
    
    .twofa-container {
        background-color: #A8C7FF;
        padding: 20px;
        width: 300px;
        text-align: center;
        border-radius: 5px;
    }
    
    h2 {
        margin-bottom: 15px;
        color: #003366;
    }
    
    .input-group {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-bottom: 10px;
    }
    
    input {
        width: 40px;
        padding: 10px;
        background-color: #78A8FF;
        border: none;
        color: white;
        text-align: center;
        font-size: 18px;
    }
    
    button {
        width: 100%;
        padding: 10px;
        background-color: #407BFF;
        border: none;
        color: white;
        cursor: pointer;
    }
    
    p {
        font-size: 12px;
        margin-top: 10px;
        color: #003366;
    }
</style>

<div class="twofa-container">
    <h2>Two-Factor Authentication</h2>
    <form id="Form">
        <div class="input-group">
            <input type="text" id="digit1" maxlength="1" required />
            <input type="text" id="digit2" maxlength="1" required />
            <input type="text" id="digit3" maxlength="1" required />
            <input type="text" id="digit4" maxlength="1" required />
        </div>
        <button type="submit">Verify</button>
    </form>
    <p id="errorMessage"></p>
</div>

        `;
    }
}