import registerController from "../controllers/registercontroller.js";
  /**
     * initializes a new instance of the register controller and assigns it to the controller
     * property of the register class
     */
export default class Register {
    constructor() {
        this.controller = new registerController();
    }

      /**
     * sets up the event listeners for the register form
     */
    bind() {
        const form = document.querySelector("#registerForm");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            
            const firstname = document.querySelector("#firstName").value;
            const preposition = document.querySelector("#preposition").value || '';
            const lastname = document.querySelector("#lastName").value;
            const mail = document.querySelector("#email").value; 
            const phonenumber = document.querySelector("#phonenumber").value;
            const password = document.querySelector("#password").value;
    
            const payload = {
                firstname,
                preposition,
                lastname,
                phonenumber,
                mail,  
                password
            };
    
            console.log("Payload before sending:", payload); 
    
            this.controller.handleRegister(payload);
        });
    }
    
  /**
     * render the register form and returns it as a string so it can be renderd
     * in the browser
     */
    render() {
        return `
            <div class="register-container">
                <h2>Register</h2>
                <form id="registerForm">
                    <input type="text" id="firstName" placeholder="Firstname" required />
                    <input type="text" id="preposition" placeholder="Preposition" />
                    <input type="text" id="lastName" placeholder="Lastname" required />
                    <input type="mail" id="email" placeholder="Email" required />
                    <input type="tel" id="phonenumber" placeholder="Phonenumber" required />
                    <input type="password" id="password" placeholder="Password" required />
                    <button type="submit">Register</button>
                   <button type="button" onclick="window.location.hash = '#/login';">Login</button> 
                </form>
                <p id="errorMessage"></p>
            </div>
        `;
    }
}
