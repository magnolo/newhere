class CmsMenuController{
    constructor(){
        'ngInject';

        //
        this.items = [
          {
            sref:'cms.dashboard',
            icon:'dashboard',
            title:'Dashboard'
          },
          {
            sref:'cms.offers',
            icon:'local_offer',
            title:'Offers'
          },
          {
            sref:'cms.ngos',
            icon:'business',
            title:'NGOs'
          },
          {
            sref:'cms.translations',
            icon:'translate',
            title:'Translations'
          },
          {
            sref:'cms.categories',
            icon:'list',
            title:'Categories'
          },
          {
            sref:'cms.languages',
            icon:'font_download',
            title:'Languages'
          },
          {
            sref:'cms.users',
            icon:'group',
            title:'Users'
          }
          // {
          //   sref:'cms.roles',
          //   icon:'streetview',
          //   title:'Roles'
          // },

        ]
    }

    $onInit(){
    }
}

export const CmsMenuComponent = {
    templateUrl: './views/app/components/cms-menu/cms-menu.component.html',
    controller: CmsMenuController,
    controllerAs: 'vm',
    bindings: {}
}
