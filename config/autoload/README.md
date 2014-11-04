About this directory:
=====================

By default, this application is configured to load all configs in
`./config/autoload/{global,local}/{,*.}{global,local}.php`. Doing this provides a
location for a developer to drop in configuration override files provided by
modules, as well as cleanly provide individual, application-wide config files
for things like database connections, etc.
Local configs should save on each server environment separately
Global config saving in CSV 
