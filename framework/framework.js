import NotFoundComponent from "../components/notfound.js";

export default class Framework {
    constructor() {
        this.routes = {};
    }

    route(path, component) {
        this.routes[path] = component;
    }

    start() {
        const appContainer = document.querySelector('#app');

        const navigateTo = () => {
            const path = window.location.hash.slice(1);
            const ComponentClass = this.routes[path] || NotFoundComponent;
        
            const appContainer = document.querySelector("#app");
            const instance = new ComponentClass();
            
            appContainer.innerHTML = instance.render(); 
        
            if (typeof instance.bind === "function") {
                instance.bind(); 
            }
        };
        
        const navigate = (path) => {
            window.location.hash = path;
        };

        window.addEventListener('hashchange', navigateTo);
        navigateTo(); 

        return { navigate };
    }
}
