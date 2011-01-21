#!/bin/bash
################################################################################
# Sample application to run from your dialplan.
################################################################################ 

# This is the application that will be run.
export PAGIApplication=MyPAGIApplication

# Location for your log4php.properties
export log4php_properties=/tmp/log4php.properties

# Make sure this is in the include path.
export PAGIBootstrap=MyPAGIApplication.php

# Your copy of PAGI, where src/ is.
pagi=/export/users/marcelog/src/sts/PAGI

# Your copy of log4php (optional)
log4php=/usr/share/php

# PHP to run and options
php=/usr/php-5.3/bin/php
phpoptions="-d include_path=${pagi}/src/mg:${log4php}:${pagi}/docs/examples/quickstart"

# Standard.. the idea is to have a common launcher.
launcher=${pagi}/src/mg/PAGI/Application/PAGILauncher.php

# Go!
${php} ${phpoptions} ${launcher}

