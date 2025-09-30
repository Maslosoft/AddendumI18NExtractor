# AddendumI18NExtractor
This utility extract i18n labels, descriptions etc.

## Label Collector
This generator collets all `@Label` and `@Description`
annotations in code, then puts it into php file wrapped with translation function,
so gettext message extractor can get those messages.
