import NotFoundComponent from "../components/notfound.js";

export default class Framework {
     /**
     * The constructor initializes an empty object that will hold the routes.
     */
    constructor() {
        this.routes = {};
    }

     /**
     * the route method adss a new route to the routes object, it takes a path and component as arguments
     * and maps the path to the component.
     */
    route(path, component) {
        this.routes[path] = component;
    }

      /**
     * Begins the routing process. It selects the main container
     * where the components will be renderd.
     */
    start() {
        const appContainer = document.querySelector('#app');

          /**
     * defines the naviagteTo function which handles navigation
     * it extracts the current path from the url hash(removes the #)
     * and selects the component that correspons to the path.
     * if the path is not found it selects the NotFoundComponent.
     */
        const navigateTo = () => {
            const path = window.location.hash.slice(1);
            const ComponentClass = this.routes[path] || NotFoundComponent;
        
            const appContainer = document.querySelector("#app");
            const instance = new ComponentClass();
              /**
     * calls the render methods of the component and sets the innerHTML
     * of the application container to the rendered component.
     */
            appContainer.innerHTML = instance.render(); 
          /**
     * just checks if the component has a bind methods and calls it if it has it
     */
            if (typeof instance.bind === "function") {
                instance.bind(); 
            }
        };
        
          /**
     * defines the navigate method which changes the url hash to the specified path
     */
        const navigate = (path) => {
            window.location.hash = path;
        };

          /**
     * calls the navigateTo function when the hash changes
     * and calls it once to render the initial component.
     */
        window.addEventListener('hashchange', navigateTo);
        navigateTo(); 
          /**
     * Returns an object with the navigate method
     */
        return { navigate };
    }
}
