# create a new repository on the command line

```
echo "# drone-des-champs-ai-salad" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/vince7lf/drone-des-champs-ai-salad.git
git push -u origin main
```

# push an existing repository from the command line

```
git remote add origin https://github.com/vince7lf/drone-des-champs-ai-salad.git
git branch -M main
git push -u origin main
```

# set git username email credential
git config --global user.name "Vincent Le Falher"
git config --global user.email "vincent.lefalher@usherbrooke.ca"
git config credential.https://github.com.username vince7lf
git config --global credential.helper store
git config --global -e
git config -e

# old git version (using master), new local repo, repo in github, main brancvh (vs master), sync both

- create new repo in github
- set git default main branch 'main' (main vs master)

`git config --global init.defaultBranch main`

- init repo in local folder

`git init`

- add remote repo 

`git remote add origin https://github.com/vince7lf/ms4w_apps.git`

- create new branch named 'main' ('master' does not really exist, until first commit)

`git checkout -b main`

- Add content to local repo (stage)

`git add -A`

- Commit staged to local repo

`git commit -m "Initial commit"`

- retrieve/merge the GitHub content bypassing the unrelated stories error

`git pull origin main --allow-unrelated-histories`

- Push the main branch content to remote repo GitHub

`git push -u origin main`

