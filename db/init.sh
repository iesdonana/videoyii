#!/bin/sh

sudo -u postgres dropuser videoyii
sudo -u postgres dropdb videoyii
sudo -u postgres psql -c "create user videoyii password 'videoyii' superuser;"
sudo -u postgres createdb -O videoyii videoyii

