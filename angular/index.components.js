import {NgoDetailComponent} from './app/components/ngo-detail/ngo-detail.component';

import {ResetpasswordFormComponent} from './app/components/resetpassword-form/resetpassword-form.component';
import {ForgotpasswordFormComponent} from './app/components/forgotpassword-form/forgotpassword-form.component';
import {CmsNgosListComponent} from './app/components/cms-ngos-list/cms-ngos-list.component';
import {CmsOfferTranslationItemComponent} from './app/components/cms-offer-translation-item/cms-offer-translation-item.component';
import {CmsOfferTranslationTableComponent} from './app/components/cms-offer-translation-table/cms-offer-translation-table.component';
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
import {CmsOffersListComponent} from './app/components/cms-offers-list/cms-offers-list.component';

angular.module('app.components')
	.component('ngoDetail', NgoDetailComponent)
	.component('resetpasswordForm', ResetpasswordFormComponent)
	.component('forgotpasswordForm', ForgotpasswordFormComponent)
	.component('cmsNgosList', CmsNgosListComponent)
	.component('cmsOfferTranslationItem', CmsOfferTranslationItemComponent)
	.component('cmsOfferTranslationTable', CmsOfferTranslationTableComponent)
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
	.component('cmsOffersList', CmsOffersListComponent);
