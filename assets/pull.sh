#!/bin/bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/aoc
git pull origin main