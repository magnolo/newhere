import {CmsMainComponent} from './app/components/cms-main/cms-main.component';
import {CmsLanguagesComponent} from './app/components/cms-languages/cms-languages.component';
import {CmsLanguageTableComponent} from './app/components/cms-language-table/cms-language-table.component';
import {CmsCategoryFormComponent} from './app/components/cms-category-form/cms-category-form.component';
import {CmsCategoriesListComponent} from './app/components/cms-categories-list/cms-categories-list.component';
import {LoginFormComponent} from './app/components/login-form/login-form.component';
import {RegisterFormComponent} from './app/components/register-form/register-form.component';

angular.module('app.components')
	.component('cmsMain', CmsMainComponent)
	.component('cmsLanguages', CmsLanguagesComponent)
	.component('cmsLanguageTable', CmsLanguageTableComponent)
	.component('cmsCategoryForm', CmsCategoryFormComponent)
	.component('cmsCategoriesList', CmsCategoriesListComponent)
	.component('loginForm', LoginFormComponent)
	.component('registerForm', RegisterFormComponent);
