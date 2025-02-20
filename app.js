import Framework from './framework/framework.js';
import login from './components/views/login.js'; 
import register from './components/views/register.js';
import TwoFactorAuth from './components/views/2fa.js';

const app = new Framework();

app.route('/login', login);
app.route('/register', register);
app.route('/2fa', TwoFactorAuth);
const framework = app.start();


if (!window.location.hash) {
    framework.navigate('/login');
}
