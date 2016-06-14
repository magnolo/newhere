class NgoFormController{
    constructor($auth, NgoService, ToastService, $state, $translate, LanguageService, $http, $q) {
        'ngInject';

        this.$q = $q;
        this.aborter = $q.defer();
        this.$http = $http;
        angular.element(document.querySelector('#addressSearch')).$valid = false;


        this.$auth = $auth;
        this.NgoService = NgoService;
        this.ToastService = ToastService;
        this.$state = $state;
        this.$translate = $translate;
        this.$LanguageService = LanguageService;
    }

    querySearch(query) {
        if (this.$http.pendingRequests.length) {
            this.aborter.resolve();
            this.aborter = this.$q.defer();
        }
        return this.$http.get('/api/offer/autocomplete/' + query, {
            timeout: this.aborter.promise
        }).then(function(response) {
            return response.data; //
        });
    }

    selectedItemChange(item) {
        if (!item) return;
        if (!this.ngo) {
            this.ngo = {};
        }
        this.ngo.street = item.street;
        this.ngo.street_number = item.number;
        this.ngo.city = item.city;
        this.ngo.zip = item.zip;
    }

    register() {
        this.ngo.language = this.$LanguageService.activeLanguage();

        if (this.ngo.editMode) {
            this.NgoService.update(this.ngo);
        } else {
            if (!this.cms) {
                this.$auth.signup(this.ngo)
                    .then((response) => {
                        //remove this if you require email verification
                        //this.$auth.setToken(response.data);
                        this.$translate('Registrierung erfolgreich.').then((msg) => {
                            this.ToastService.show(msg);
                        });                 
                        this.$state.go('app.login');
                    })
                    .catch(this.failedRegistration.bind(this));
            } else {
                this.NgoService.create(this.ngo);
            }
        }
    }

    cancel() {
        this.NgoService.cancel(this.cms);
    }

    failedRegistration(response) {
        if (response.status === 422) {
            for (var error in response.data.errors) {
                return this.ToastService.error(response.data.errors[error][0]);
            }
        }
        this.ToastService.error(response.statusText);
    }

}

export const NgoFormComponent = {
    templateUrl: './views/app/components/ngo-form/ngo-form.component.html',
    controller: NgoFormController,
    controllerAs: 'vm',
    bindings: {
        cms: '=',
        ngo: '='
    }
}
