&lt;?php

/**
 * Classe Router - Gère le routage des URLs vers les contrôleurs
 */
class Router {
    private $routes = [];

    /**
     * Ajoute une route GET
     * @param string $path Chemin de la route
     * @param string $controller Contrôleur au format "ControllerName@method"
     */
    public function get($path, $controller) {
        $this->routes['GET'][$path] = $controller;
    }

    /**
     * Ajoute une route POST
     * @param string $path Chemin de la route
     * @param string $controller Contrôleur au format "ControllerName@method"
     */
    public function post($path, $controller) {
        $this->routes['POST'][$path] = $controller;
    }

    /**
     * Dispatche la requête vers le bon contrôleur
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Retire le nom du dossier si l'app est dans un sous-dossier
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if($scriptName !== '/') {
            $uri = str_replace($scriptName, '', $uri);
        }

        // Cherche une correspondance exacte
        if(isset($this->routes[$method][$uri])) {
            $this->call($this->routes[$method][$uri]);
            return;
        }

        // Cherche une correspondance avec paramètres
        foreach($this->routes[$method] as $route => $controller) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if(preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->call($controller, $matches);
                return;
            }
        }

        // Route non trouvée
        http_response_code(404);
        echo "404 - Page non trouvée";
    }

    /**
     * Appelle le contrôleur et la méthode
     * @param string $controller Contrôleur au format "ControllerName@method"
     * @param array $params Paramètres à passer à la méthode
     */
    private function call($controller, $params = []) {
        list($controllerName, $method) = explode('@', $controller);

        $controllerPath = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if(file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerInstance = new $controllerName();

            if(method_exists($controllerInstance, $method)) {
                call_user_func_array([$controllerInstance, $method], $params);
            } else {
                die("Méthode introuvable : " . $method);
            }
        } else {
            die("Contrôleur introuvable : " . $controllerName);
        }
    }
}
