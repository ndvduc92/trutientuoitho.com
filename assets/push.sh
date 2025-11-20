#!/bin/bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/aoc
git add .
git commit -m "acac"
git push origin main