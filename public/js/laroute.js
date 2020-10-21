(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"oauth\/authorize","name":"passport.authorizations.authorize","action":"\Laravel\Passport\Http\Controllers\AuthorizationController@authorize"},{"host":null,"methods":["POST"],"uri":"oauth\/authorize","name":"passport.authorizations.approve","action":"\Laravel\Passport\Http\Controllers\ApproveAuthorizationController@approve"},{"host":null,"methods":["DELETE"],"uri":"oauth\/authorize","name":"passport.authorizations.deny","action":"\Laravel\Passport\Http\Controllers\DenyAuthorizationController@deny"},{"host":null,"methods":["POST"],"uri":"oauth\/token","name":"passport.token","action":"\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken"},{"host":null,"methods":["GET","HEAD"],"uri":"oauth\/tokens","name":"passport.tokens.index","action":"\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@forUser"},{"host":null,"methods":["DELETE"],"uri":"oauth\/tokens\/{token_id}","name":"passport.tokens.destroy","action":"\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@destroy"},{"host":null,"methods":["POST"],"uri":"oauth\/token\/refresh","name":"passport.token.refresh","action":"\Laravel\Passport\Http\Controllers\TransientTokenController@refresh"},{"host":null,"methods":["GET","HEAD"],"uri":"oauth\/clients","name":"passport.clients.index","action":"\Laravel\Passport\Http\Controllers\ClientController@forUser"},{"host":null,"methods":["POST"],"uri":"oauth\/clients","name":"passport.clients.store","action":"\Laravel\Passport\Http\Controllers\ClientController@store"},{"host":null,"methods":["PUT"],"uri":"oauth\/clients\/{client_id}","name":"passport.clients.update","action":"\Laravel\Passport\Http\Controllers\ClientController@update"},{"host":null,"methods":["DELETE"],"uri":"oauth\/clients\/{client_id}","name":"passport.clients.destroy","action":"\Laravel\Passport\Http\Controllers\ClientController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"oauth\/scopes","name":"passport.scopes.index","action":"\Laravel\Passport\Http\Controllers\ScopeController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"oauth\/personal-access-tokens","name":"passport.personal.tokens.index","action":"\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@forUser"},{"host":null,"methods":["POST"],"uri":"oauth\/personal-access-tokens","name":"passport.personal.tokens.store","action":"\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@store"},{"host":null,"methods":["DELETE"],"uri":"oauth\/personal-access-tokens\/{token_id}","name":"passport.personal.tokens.destroy","action":"\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"},{"host":null,"methods":["POST"],"uri":"api\/login","name":"login","action":"App\Http\Controllers\TokenController@login"},{"host":null,"methods":["POST"],"uri":"api\/validate","name":"validate","action":"App\Http\Controllers\TokenController@validateToken"},{"host":null,"methods":["POST"],"uri":"api\/teste","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"tenancy\/new","name":null,"action":"App\Http\Controllers\Teste@online"},{"host":null,"methods":["GET","HEAD"],"uri":"config","name":null,"action":"App\Http\Controllers\Teste@configOauth"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"default","action":"App\Http\Controllers\LoginController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":null,"action":"App\Http\Controllers\LoginController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"pops","name":"pop.index","action":"App\Http\Controllers\PopController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"pops\/list","name":"pop.list","action":"App\Http\Controllers\PopController@list"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/create","name":"pop.create","action":"App\Http\Controllers\PopController@create"},{"host":null,"methods":["POST"],"uri":"pop","name":"pop.store","action":"App\Http\Controllers\PopController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/selects","name":"pop.selects","action":"App\Http\Controllers\PopController@selects"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/edit\/{id}","name":"pop.edit","action":"App\Http\Controllers\PopController@edit"},{"host":null,"methods":["PUT"],"uri":"pop\/update\/{id}","name":"pop.update","action":"App\Http\Controllers\PopController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/historic\/{id}","name":"pop.historic","action":"App\Http\Controllers\PopHistoricController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/historic\/list\/{id}","name":"pop.historiclist","action":"App\Http\Controllers\PopHistoricController@list"},{"host":null,"methods":["PUT"],"uri":"pop\/version\/{id}","name":"pop.version","action":"App\Http\Controllers\PopController@version"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/duplicate\/{id}","name":"pop.duplicate","action":"App\Http\Controllers\PopController@duplicate"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/pdf\/{id}","name":"pop.pdf","action":"App\Http\Controllers\PopController@pdf"},{"host":null,"methods":["GET","HEAD"],"uri":"pop\/{id}","name":"pop.show","action":"App\Http\Controllers\PopController@show"},{"host":null,"methods":["DELETE"],"uri":"pop\/delete\/{id}","name":"pop.delete","action":"App\Http\Controllers\PopController@destroy"},{"host":null,"methods":["POST"],"uri":"upload","name":"upload.store","action":"App\Http\Controllers\UploadController@store"},{"host":null,"methods":["PUT"],"uri":"upload","name":"upload.store","action":"App\Http\Controllers\UploadController@store"},{"host":null,"methods":["DELETE"],"uri":"upload\/delete\/{id}","name":"upload.delete","action":"App\Http\Controllers\UploadController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"media\/{path}","name":"tenant.media","action":"\Hyn\Tenancy\Controllers\MediaController"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

