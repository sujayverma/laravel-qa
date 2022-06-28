import policies from './policies';

export default {
    install(Vue, options) {
        // Modifiying vue js prototype. Prototype is way to inherit a class. And by doing this we add authorize function component without any injection mehcanism.
        Vue.prototype.authorize = function (policy, model) {
            if ( ! window.Auth.signedIn)
                return false;

            if ( typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;

                return policies[policy](user, model);
            }
        }

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}
