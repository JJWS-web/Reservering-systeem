import Framework from './framework/framework.js';
import login from './components/views/login.js'; 
import register from './components/views/register.js';
import TwoFactorAuth from './components/views/2fa.js';

const app = new Framework();
  /**
     * defines the routes for the application
     */
app.route('/login', login);
app.route('/register', register);
app.route('/2fa', TwoFactorAuth);
  /**
     * starts the framework by calling the start method
     */
const framework = app.start();

  /**
     * checks if the url has a hash if not it navigates to login
     */
if (!window.location.hash) {
    framework.navigate('/login');
}
