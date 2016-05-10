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

angular.module('app.components')
	.component('ngoForm', NgoFormComponent)
	.component('userMenu', UserMenuComponent)
	.component('cmsRolesTable', CmsRolesTableComponent)
	.component('cmsMain', CmsMainComponent)
	.component('cmsLanguages', CmsLanguagesComponent)
	.component('cmsLanguageTable', CmsLanguageTableComponent)
	.component('cmsCategoryForm', CmsCategoryFormComponent)
	.component('cmsCategoriesList', CmsCategoriesListComponent)
	.component('loginForm', LoginFormComponent)
	.component('registerForm', RegisterFormComponent);
