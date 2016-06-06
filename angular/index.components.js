import {CmsFilterTranslationItemComponent} from './app/components/cms-filter-translation-item/cms-filter-translation-item.component';
import {CmsFilterTranslationTableComponent} from './app/components/cms-filter-translation-table/cms-filter-translation-table.component';
import {OffersListComponent} from './app/components/offers-list/offers-list.component';
import {CmsNgoTranslationItemComponent} from './app/components/cms-ngo-translation-item/cms-ngo-translation-item.component';
import {CmsNgoTranslationTableComponent} from './app/components/cms-ngo-translation-table/cms-ngo-translation-table.component';
import {AppCategoriesContentSubComponent} from './app/components/app-categories-content-sub/app-categories-content-sub.component';
import {AppCategoriesContentComponent} from './app/components/app-categories-content/app-categories-content.component';
import {AppCategoriesToolbarComponent} from './app/components/app-categories-toolbar/app-categories-toolbar.component';
import {LocatorComponent} from './app/components/locator/locator.component';
import {MapComponent} from './app/components/map/map.component';
import {NgoUsersListComponent} from './app/components/ngo-users-list/ngo-users-list.component';
import {WizardOfferComponent} from './app/components/wizard-offer/wizard-offer.component';
import {CmsCategoryTranslationItemComponent} from './app/components/cms-category-translation-item/cms-category-translation-item.component';
import {CmsCategoryTranslationTableComponent} from './app/components/cms-category-translation-table/cms-category-translation-table.component';
import {WidgetCategoriesComponent} from './app/components/widget-categories/widget-categories.component';
import {WidgetOfferComponent} from './app/components/widget-offer/widget-offer.component';
import {FilterSelectorComponent} from './app/components/filter-selector/filter-selector.component';
import {CmsMenuComponent} from './app/components/cms-menu/cms-menu.component';
import {WidgetNgoComponent} from './app/components/widget-ngo/widget-ngo.component';
import {UserComponent} from './app/components/user/user.component';
import {MyNgoDetailComponent} from './app/components/my-ngo-detail/my-ngo-detail.component';
import {NgoDetailComponent} from './app/components/ngo-detail/ngo-detail.component';
import {ResetpasswordFormComponent} from './app/components/resetpassword-form/resetpassword-form.component';
import {ForgotpasswordFormComponent} from './app/components/forgotpassword-form/forgotpassword-form.component';
import {CmsNgosListComponent} from './app/components/cms-ngos-list/cms-ngos-list.component';
import {CmsOfferTranslationItemComponent} from './app/components/cms-offer-translation-item/cms-offer-translation-item.component';
import {CmsOfferTranslationTableComponent} from './app/components/cms-offer-translation-table/cms-offer-translation-table.component';
import {CmsOfferDetailComponent} from './app/components/cms-offer-detail/cms-offer-detail.component';
import {ImageUploaderComponent} from './app/components/image-uploader/image-uploader.component';
import {CmsUsersTableComponent} from './app/components/cms-users-table/cms-users-table.component';
import {NgoFormComponent} from './app/components/ngo-form/ngo-form.component';
import {UserMenuComponent} from './app/components/user-menu/user-menu.component';
import {CmsRolesTableComponent} from './app/components/cms-roles-table/cms-roles-table.component';
import {CmsMainComponent} from './app/components/cms-main/cms-main.component';
import {CmsLanguagesComponent} from './app/components/cms-languages/cms-languages.component';
import {CmsLanguageTableComponent} from './app/components/cms-language-table/cms-language-table.component';
import {CmsCategoryFormComponent} from './app/components/cms-category-form/cms-category-form.component';
import {CmsCategoriesListComponent} from './app/components/cms-categories-list/cms-categories-list.component';
import {LoginFormComponent} from './app/components/login-form/login-form.component';
import {RegisterFormComponent} from './app/components/register-form/register-form.component';
import {OfferFormComponent} from './app/components/offer-form/offer-form.component';
import {CmsOffersListComponent} from './app/components/cms-offers-list/cms-offers-list.component';
import {CmsFiltersListComponent} from './app/components/cms-filters-list/cms-filters-list.component';
import {CmsFilterFormComponent} from './app/components/cms-filter-form/cms-filter-form.component';

angular.module('app.components')
	.component('cmsFilterTranslationItem', CmsFilterTranslationItemComponent)
	.component('cmsFilterTranslationTable', CmsFilterTranslationTableComponent)
	.component('offersList', OffersListComponent)
	.component('cmsNgoTranslationItem', CmsNgoTranslationItemComponent)
	.component('cmsNgoTranslationTable', CmsNgoTranslationTableComponent)
	.component('appCategoriesContentSub', AppCategoriesContentSubComponent)
	.component('appCategoriesContent', AppCategoriesContentComponent)
	.component('appCategoriesToolbar', AppCategoriesToolbarComponent)
	.component('locator', LocatorComponent)
	.component('map', MapComponent)
	.component('ngoUsersList', NgoUsersListComponent)
	.component('wizardOffer', WizardOfferComponent)
	.component('cmsCategoryTranslationItem', CmsCategoryTranslationItemComponent)
	.component('cmsCategoryTranslationTable', CmsCategoryTranslationTableComponent)
	.component('widgetCategories', WidgetCategoriesComponent)
	.component('widgetOffer', WidgetOfferComponent)
	.component('filterSelector', FilterSelectorComponent)
	.component('cmsMenu', CmsMenuComponent)
	.component('widgetNgo', WidgetNgoComponent)
	.component('user', UserComponent)
	.component('myNgoDetail', MyNgoDetailComponent)
	.component('ngoDetail', NgoDetailComponent)
	.component('resetpasswordForm', ResetpasswordFormComponent)
	.component('forgotpasswordForm', ForgotpasswordFormComponent)
	.component('cmsNgosList', CmsNgosListComponent)
	.component('cmsOfferTranslationTable', CmsOfferTranslationTableComponent)
	.component('cmsOfferTranslationItem', CmsOfferTranslationItemComponent)
	.component('cmsOfferDetail', CmsOfferDetailComponent)
	.component('imageUploader', ImageUploaderComponent)
	.component('cmsUsersTable', CmsUsersTableComponent)
	.component('ngoForm', NgoFormComponent)
	.component('userMenu', UserMenuComponent)
	.component('cmsRolesTable', CmsRolesTableComponent)
	.component('cmsMain', CmsMainComponent)
	.component('cmsLanguages', CmsLanguagesComponent)
	.component('cmsLanguageTable', CmsLanguageTableComponent)
	.component('cmsCategoryForm', CmsCategoryFormComponent)
	.component('cmsCategoriesList', CmsCategoriesListComponent)
	.component('loginForm', LoginFormComponent)
	.component('registerForm', RegisterFormComponent)
	.component('offerForm', OfferFormComponent)
	.component('cmsOffersList', CmsOffersListComponent)
	.component('cmsFiltersList', CmsFiltersListComponent)
	.component('cmsFilterForm', CmsFilterFormComponent);
