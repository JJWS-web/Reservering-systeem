import loginController from "../controllers/logincontroller.js";

export default class login {
    constructor() {
        this.controller = new loginController();
    }

    bind() {
        const form = document.querySelector("#loginForm");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            const mail = document.querySelector("#mail").value;
            const password = document.querySelector("#password").value;
            
           
            this.controller.handleLogin(mail, password);
        });
    }

    render() {
        return `
            <div>
                <h2>Login</h2>
                <form id="loginForm">
                    <input type="text" id="mail" placeholder="Mail" required />
                    <input type="password" id="password" placeholder="Password" required />
                    <button type="submit">Login</button>
                    <button type="button" onclick="window.location.hash = '#/register';">Register</button> 
                </form>
                <p id="errorMessage"></p>
            </div>
        `;
    }
}
