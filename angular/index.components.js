import {CmsLanguageTableComponent} from './app/components/cms-language-table/cms-language-table.component';
import {CmsCategoryFormComponent} from './app/components/cms-category-form/cms-category-form.component';
import {CmsCategoryListComponent} from './app/components/cms-category-list/cms-category-list.component';
import {LoginFormComponent} from './app/components/login-form/login-form.component';
import {RegisterFormComponent} from './app/components/register-form/register-form.component';

angular.module('app.components')
	.component('cmsLanguageTable', CmsLanguageTableComponent)
	.component('cmsCategoryForm', CmsCategoryFormComponent)
	.component('cmsCategoryList', CmsCategoryListComponent)
	.component('loginForm', LoginFormComponent)
	.component('registerForm', RegisterFormComponent);

