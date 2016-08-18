import {MaterialConfig} from './config/material.config';
import {TranslateConfig} from './config/translate.config';
import {FlowConfig} from './config/flow.config';
import {RoutesConfig} from './config/routes.config';
import {LoadingBarConfig} from './config/loading_bar.config';
import {ThemeConfig} from './config/theme.config';
import {SatellizerConfig} from './config/satellizer.config';

angular.module('app.config')
	.config(MaterialConfig)
	.config(TranslateConfig)
	.config(FlowConfig)
    .config(RoutesConfig)
	.config(LoadingBarConfig)
	.config(ThemeConfig)
	.config(SatellizerConfig);
