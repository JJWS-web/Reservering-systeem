import loginController from "../controllers/logincontroller.js";

export default class login {
      /**
     * initializes a new instance  login controller and assigns it 
     * to the controller propertt of login class
     */
    constructor() {
        this.controller = new loginController();
    }
    
      /**
     * sets up the event listeners for the login form
     */
    bind() {
        const form = document.querySelector("#loginForm");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            const mail = document.querySelector("#mail").value;
            const password = document.querySelector("#password").value;
           
           
            this.controller.handleLogin(mail, password);
        });
    }

      /**
     * renders the login form and returns it as a string so it can be renderd
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
    
    .login-container {
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
    
    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        background-color: #78A8FF;
        border: none;
        color: white;
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
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-top: 10px;
        color: #003366;
    }
</style>

<div class="login-container">
    <h2>Login</h2>
    <form id="loginForm">
        <input type="text" id="mail" placeholder="Email field" required />
        <input type="password" id="password" placeholder="Password field" required />
        <button type="submit">Login button</button>
        
    </form>
    <p>
        <span>Forgot password?</span>
        <span>Don't have an account <a href="#/register">register here</a>?</span>
    </p>
</div>
        `;
    }
}
