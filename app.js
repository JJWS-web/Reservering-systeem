import Framework from './framework/framework.js';
import login from './components/views/login.js'; 
import register from './components/views/register.js';

const app = new Framework();

app.route('/login', login);
app.route('/register', register);
const framework = app.start();


if (!window.location.hash) {
    framework.navigate('/login');
}
