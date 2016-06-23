class LoaderController {
    constructor() {
        'ngInject';

        //
    }

    $onInit() {}
}

export const LoaderComponent = {
    templateUrl: './views/app/components/loader/loader.component.html',
    controller: LoaderController,
    controllerAs: 'vm',
    bindings: {
        condition: '='
    }
}