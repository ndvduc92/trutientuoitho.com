#!/bin/bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/aoc
git add .
current_date_time="`date "+%Y-%m-%d %H:%M:%S"`";
git commit -m "$current_date_time"
git push origin main