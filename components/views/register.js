import RegisterController from "../controllers/registercontroller.js";

export default class Register {
    constructor() {
        this.controller = new RegisterController();
    }

    bind() {
        const form = document.querySelector("#registerForm");
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            
            const firstName = document.querySelector("#firstName").value;
            const middleName = document.querySelector("#preposition").value || '';
            const lastName = document.querySelector("#lastName").value;
            const email = document.querySelector("#email").value;
            const phone = document.querySelector("#phonenumber").value;
            const password = document.querySelector("#password").value;

            this.controller.handleRegister({
                firstName,
                middleName,
                lastName,
                email,
                phone,
                password
            });
        });
    }

    render() {
        return `
            <div class="register-container">
                <h2>Register</h2>
                <form id="registerForm">
                    <input type="text" id="firstName" placeholder="Firstname" required />
                    <input type="text" id="preposition" placeholder="Preposition" />
                    <input type="text" id="lastName" placeholder="Lastname" required />
                    <input type="email" id="email" placeholder="Email" required />
                    <input type="tel" id="phonenumber" placeholder="Phonenumber" required />
                    <input type="password" id="password" placeholder="Password" required />
                    <button type="submit">Register</button>
                </form>
                <p id="errorMessage"></p>
            </div>
        `;
    }
}
