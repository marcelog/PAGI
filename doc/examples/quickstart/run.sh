#!/bin/bash
################################################################################
# Sample application to run from your dialplan.
################################################################################
# Get our base directory (the one where this script is located)
me=$(dirname ${0})
root=${me}/../../..
export root=`cd ${root}; pwd`

# This is the application that will be run.
export PAGIApplication=MyPAGIApplication

# Make sure this is in the include path.
export PAGIBootstrap=MyPAGIApplication.php

# PHP to run and options
php=/usr/php/bin/php
phpoptions="-c ${root}/resources/php.ini -d include_path=${root}/docs/examples/quickstart"

# Standard.. the idea is to have a common launcher.
launcher=${root}/src/mg/PAGI/Application/PAGILauncher.php

# Go!
${php} ${phpoptions} ${launcher}

