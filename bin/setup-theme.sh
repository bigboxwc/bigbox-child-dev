#!/bin/bash

# Include useful functions
. "$(dirname "$0")/includes.sh"

# Exit if any command fails
set -e

# Change to the expected directory
cd "$(dirname "$0")"
cd ..

# Do a dry run of the repository reset. Prompting the user for a list of all
# files that will be removed should prevent them from losing important files!
status_message "Resetting the repository to pristine condition."
git clean -xdf --dry-run

if ask "$(error_message "About to delete everything above! Is this okay?")" Y; then
	# Remove ignored files to reset repository to pristine condition. Previous
	# test ensures that changed files abort the plugin build.
	status_message "Cleaning working directory..."
	git clean -xdf
else
	error_message "Aborting."
	exit 0
fi

status_message "Installing Node modules..."
npm install

status_message "Installing PHP dependencies..."
composer install

status_message "Building and watching assets..."
npm run dev
