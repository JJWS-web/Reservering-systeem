import LoginController from "../controllers/logincontroller.js";

export default class login {
    constructor() {
        this.controller = new LoginController();
    }

    bind() {
        const form = document.querySelector("#loginForm");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            const username = document.querySelector("#username").value;
            const password = document.querySelector("#password").value;
            
           
            this.controller.handleLogin(username, password);
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
                </form>
                <p id="errorMessage"></p>
            </div>
        `;
    }
}
