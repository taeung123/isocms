window.App = (function ($, window, document) {
    /* ================= INTERNAL STATE ================= */

    let modules = [];

    let container = null;
    let actionRegistry = null;
    let middlewareManager = null;
    let eventManager = null;

    let isInitialized = false;
    let isStarted = false;

    /* ================= SERVICE CONTAINER ================= */

    function ServiceContainer() {
        this.services = {};
    }

    ServiceContainer.prototype.register = function (name, service) {
        if (this.services[name]) {
            console.warn("⚠️ Service already exists:", name);
            return;
        }

        this.services[name] = service;
    };

    ServiceContainer.prototype.get = function (name) {
        let service = this.services[name];

        if (!service) {
            console.warn("⚠️ Service not found:", name);
            return null;
        }

        /* Lazy support */

        if (typeof service === "function") {
            service = service();

            this.services[name] = service;
        }

        return service;
    };

    ServiceContainer.prototype.has = function (name) {
        return !!this.services[name];
    };

    /* ================= ACTION REGISTRY ================= */

    function ActionRegistry() {
        this.actions = {};
    }

    ActionRegistry.prototype.register = function (name, handler) {
        if (!name || typeof handler !== "function") {
            console.warn("⚠️ Invalid action:", name);
            return;
        }

        if (!this.actions[name]) {
            this.actions[name] = [];
        }

        /* Prevent duplicate handler */

        if (this.actions[name].includes(handler)) {
            console.warn("⚠️ Action already registered:", name);
            return;
        }

        this.actions[name].push(handler);
    };

    ActionRegistry.prototype.has = function (name) {
        return !!this.actions[name];
    };

    ActionRegistry.prototype.execute = function (name, ctx = {}) {
        const handlers = this.actions[name];

        if (!handlers) {
            return Promise.resolve(null);
        }

        return handlers.reduce(
            (chain, handler) => {
                return chain.then(() => {
                    try {
                        const result = handler(ctx);

                        if (result instanceof Promise) {
                            return result.catch(function (err) {
                                console.error(
                                    "❌ Async action error:",
                                    name,
                                    err,
                                );
                            });
                        }
                    } catch (err) {
                        console.error("❌ Action error:", name, err);
                    }
                });
            },

            Promise.resolve(),
        );
    };

    ActionRegistry.prototype.executeMany = function (names, ctx) {
        if (!Array.isArray(names)) {
            return Promise.resolve();
        }

        return names.reduce(
            (chain, name) => {
                return chain.then(() => {
                    return this.execute(name, ctx);
                });
            },

            Promise.resolve(),
        );
    };

    /* ================= MIDDLEWARE ================= */

    function MiddlewareManager() {
        this.middlewares = [];
    }

    MiddlewareManager.prototype.use = function (fn) {
        if (typeof fn !== "function") {
            console.warn("⚠️ Invalid middleware");
            return;
        }

        this.middlewares.push(fn);
    };

    MiddlewareManager.prototype.run = function (ctx = {}) {
        return this.middlewares.reduce(
            (chain, middleware) => {
                return chain.then(() => {
                    try {
                        let result = middleware(ctx);

                        if (result instanceof Promise) {
                            return result.catch(function (err) {
                                console.error("❌ Middleware error:", err);
                            });
                        }
                    } catch (err) {
                        console.error("❌ Middleware error:", err);
                    }
                });
            },

            Promise.resolve(),
        );
    };

    /* ================= EVENT MANAGER ================= */

    function EventManager(actionRegistry, middlewareManager) {
        this.actionRegistry = actionRegistry;

        this.middlewareManager = middlewareManager;

        this.events = [];
    }

    EventManager.prototype.register = function (config) {
        let self = this;

        if (!config?.type || !config?.selector) {
            console.warn("⚠️ Invalid event config:", config);
            return;
        }

        /* Prevent duplicate event */

        let exists = this.events.find(
            (evt) =>
                evt.type === config.type && evt.selector === config.selector,
        );

        if (exists) {
            console.warn("⚠️ Event already registered:", config);
            return;
        }

        const handler = function (e) {
            let actionName = config.action || $(this).data("action");

            if (!actionName) return;

            let ctx = {
                event: e,
                element: this,
            };

            self.middlewareManager
                .run(ctx)

                .then(function () {
                    return self.actionRegistry.execute(actionName, ctx);
                })

                .catch(function (err) {
                    console.error("❌ Event chain error:", err);
                });
        };

        $(document).on(config.type, config.selector, handler);

        this.events.push({
            type: config.type,
            selector: config.selector,
            handler,
        });
    };

    EventManager.prototype.destroy = function () {
        this.events.forEach(function (evt) {
            $(document).off(evt.type, evt.selector, evt.handler);
        });

        this.events = [];
    };

    /* ================= MODULE ================= */

    function registerModule(moduleInitFunction) {
        if (typeof moduleInitFunction !== "function") {
            console.warn("⚠️ Invalid module");
            return;
        }

        modules.push(moduleInitFunction);

        /* Hot register support */

        if (isInitialized) {
            try {
                moduleInitFunction({
                    container,
                    actionRegistry,
                    middlewareManager,
                    eventManager,
                });
            } catch (err) {
                console.error("❌ Hot module init error:", err);
            }
        }
    }

    /* ================= INIT ================= */

    function init() {
        if (isInitialized) return;

        container = new ServiceContainer();

        actionRegistry = new ActionRegistry();

        middlewareManager = new MiddlewareManager();

        eventManager = new EventManager(actionRegistry, middlewareManager);

        modules.forEach(function (module) {
            try {
                module({
                    container,
                    actionRegistry,
                    middlewareManager,
                    eventManager,
                });
            } catch (err) {
                console.error("❌ Module error:", err);
            }
        });

        isInitialized = true;

        actionRegistry.execute("app.init");
    }

    /* ================= START ================= */

    function start() {
        if (!isInitialized || isStarted) return;

        isStarted = true;

        /* DOM READY */

        actionRegistry.execute("app.ready");

        /* WINDOW LOAD */

        $(window).on("load", function () {
            actionRegistry.execute("app.loaded");
        });
    }

    /* ================= DISPATCH ================= */

    function dispatch(actionName, ctx = {}) {
        if (!isInitialized) return;

        return middlewareManager
            .run(ctx)

            .then(() => {
                return actionRegistry.execute(actionName, ctx);
            })

            .catch(function (err) {
                console.error("❌ Dispatch error:", actionName, err);
            });
    }

    /* ================= DEBUG ================= */

    function debug() {
        return {
            services: container.services,

            actions: actionRegistry.actions,

            middlewares: middlewareManager.middlewares,

            events: eventManager.events,
        };
    }

    /* ================= PUBLIC ================= */

    return {
        init,
        start,
        dispatch,
        registerModule,
        debug,
    };
})(jQuery, window, document);

/* ================= BOOTSTRAP ================= */

$(function () {
    App.init();

    App.start();
});

/* ================= GLOBAL ERROR HANDLER ================= */

window.onerror = function (message, source, lineno, colno, error) {
    console.error("❌ Global Error:", message, source, lineno);

    return false;
};

window.onunhandledrejection = function (event) {
    console.error("❌ Unhandled Promise:", event.reason);

    return false;
};
