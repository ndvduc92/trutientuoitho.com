#!/bin/bash
cd public_html/id.trutienvietnam.com/
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/aocdailuc
git pull origin master