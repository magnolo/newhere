import {NgoPublishedFilter} from './filters/ngo_published.filter';
import {TranslationFilter} from './filters/translation.filter';
import {CapitalizeFilter} from './filters/capitalize.filter';
import {HumanReadableFilter} from './filters/human_readable.filter';
import {TruncatCharactersFilter} from './filters/truncate_characters.filter';
import {TruncateWordsFilter} from './filters/truncate_words.filter';
import {TrustHtmlFilter} from './filters/trust_html.filter';
import {UcFirstFilter} from './filters/ucfirst.filter';
import {OfferEnabledFilter} from './filters/offer_enabled.filter';
import {FilterEnabledFilter} from './filters/filter_enabled.filter';

angular.module('app.filters')
	.filter('ngoPublished', NgoPublishedFilter)
	.filter('translation', TranslationFilter)
	.filter('capitalize', CapitalizeFilter)
	.filter('humanReadable', HumanReadableFilter)
	.filter('truncateCharacters', TruncatCharactersFilter)
	.filter('truncateWords', TruncateWordsFilter)
	.filter('trustHtml', TrustHtmlFilter)
	.filter('ucfirst', UcFirstFilter)
	.filter('offerEnabled', OfferEnabledFilter)
	.filter('filterEnabled', FilterEnabledFilter);
