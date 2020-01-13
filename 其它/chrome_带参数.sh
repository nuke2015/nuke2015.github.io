#!/bin/bash

# Note: exec -a below is a bashism.
exec -a "$0" "/opt/google/chrome/google-chrome-base" --no-sandbox "$@"
