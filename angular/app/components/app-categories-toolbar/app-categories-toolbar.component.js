class AppCategoriesToolbarController {
    constructor($rootScope, CategoryService, $state, $mdSidenav, OfferService) {
        'ngInject';

        //
        this.$state = $state;
        this.$root = $rootScope;
        this.$mdSidenav = $mdSidenav;
        this.CategoryService = CategoryService;
        this.OfferService = OfferService;
        this.hideFilter = false;
        if ($state.current.data.hideFilter) {
            this.hideFilter = $state.current.data.hideFilter;
        }
    }

    $onInit() {}
    showFilter() {
        this.$mdSidenav('main-menu').close();
        this.$mdSidenav('filter').toggle();
    }
    goBack() {
        history.back();
        // if (this.$root.fromState) {
        //     this.$state.go(this.$root.fromState, this.$root.fromParams);
        // } else {
        //     this.$state.go('app.start.categories');
        // }
        // if (this.$state.current.name == "app.start.detail") {
        //     if (this.OfferService.offer.categories[0].id) {
        //         this.$state.go('app.start.categories.sub', {
        //             slug: this.OfferService.offer.categories[0].slug
        //         });
        //     } else {
        //
        //     }
        // } else if (this.CategoryService.category.parent_id) {
        //     this.$state.go('app.start.categories.sub', {
        //         slug: this.CategoryService.category.parent.slug
        //     });
        // } else {
        //     this.$state.go('app.start.categories');
        // }
    }
}

export const AppCategoriesToolbarComponent = {
    templateUrl: './views/app/components/app-categories-toolbar/app-categories-toolbar.component.html',
    controller: AppCategoriesToolbarController,
    controllerAs: 'vm',
    bindings: {
        hideFilterBtn: '='
    }
}