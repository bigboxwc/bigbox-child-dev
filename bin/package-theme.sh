#!/bin/bash

# Include useful functions
. "$(dirname "$0")/includes.sh"

# Exit if any command fails
set -e

# Change to the expected directory
cd "$(dirname "$0")"
cd ..

# Get version number from package.json
PACKAGE_VERSION=$(cat package.json \
  | grep version \
  | head -1 \
  | awk -F: '{ print $2 }' \
  | sed 's/[",]//g' \
  | tr -d '[[:space:]]')

# Make sure there are no changes in the working tree.  Release builds should be
# traceable to a particular commit and reliably reproducible.
changed=
if ! git diff --exit-code > /dev/null; then
	changed="file(s) modified"
elif ! git diff --cached --exit-code > /dev/null; then
	changed="file(s) staged"
fi
if [ ! -z "$changed" ]; then
	git status
	error_message "ERROR: Cannot build theme zip with dirty working tree. Commit your changes and try again."
	exit 1
fi

branch="$(git rev-parse --abbrev-ref HEAD)"
if [ "$branch" != 'master' ]; then
	warning_message "WARNING: You should probably be running this script against the master' branch (current: '$branch')"
	echo
	sleep 2
fi

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

# Run the build
status_message "Installing dependencies..."
npm install
composer install

status_message "Generating build..."
npm run build

# Update version in files.
sed -i "" "s|%BIGBOX_CHILD_VERSION%|${PACKAGE_VERSION}|g" style.css
sed -i "" "s|%BIGBOX_CHILD_VERSION%|${PACKAGE_VERSION}|g" functions.php

# Remove any existing zip file
rm -f bigbox*.zip

# Generate the theme zip file
status_message "Creating archive..."
zip -r bigbox-child.zip \
	functions.php \
	style.css \
	app \
	bootstrap \
	resources/views \
	public \
	vendor/ \
	LICENSE \
	CHANGELOG.md \
	screenshot.png \
	-x *.git*

# Rename and cleanup.
unzip bigbox-child.zip -d bigbox-child && zip -r "bigbox-child-$PACKAGE_VERSION.zip" bigbox-child
rm -rf bigbox-child && rm -f bigbox-child.zip

# Reset generated files.
git reset head --hard

success_message "📦  Version $PACKAGE_VERSION build complete."
