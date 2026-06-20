#!/usr/bin/env bash
# Runnable without execute bit: bash deploy.sh
exec bash "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/deployment/hostinger/deploy.sh" "$@"
