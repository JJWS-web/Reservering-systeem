import Framework from './framework/framework.js';
import login from './components/views/login.js'; 

const app = new Framework();

app.route('/login', login);

const framework = app.start();


if (!window.location.hash) {
    framework.navigate('/login');
}
