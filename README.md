# LAMP/WAMP STACK

edit config.php with necessary db connection data

## How to commit for collaborators

1. Clone the repo

``` git
git clone git@github.com:NorthOC/learning-platform.git
cd learning-platform
```

2. Create branch for new feature

``` git
git branch -m new-feature-name
```

3. Code add, commit and push the feature

After coding in your feature

``` git
git add .
git commit -m "your changes here"
git push origin HEAD
```

4. Submit a pull request via github

5. Delete branch on your machine

``` git
git checkout main
git branch -D new-feature-name
```

After a pull request, you can either merge yourself or NorthOC will do the merge.

## How to commit for anyone

1. Fork the repository

2. Clone the forked repo

``` git
git clone git@github.com:YOUR_USERNAME/learning-platform.git
cd learning-platform
```

3. Create branch for new feature and configure upstream to point at the original repo

``` git
git branch -m new-feature-name
git remote add upstream https://github.com/NorthOC/learning-platform.git
```

4. Code add, commit and push the feature

After coding in your feature

``` git
git add .
git commit -m "your changes here"
git push
```

5. Submit a pull request via github

5. Delete branch on your machine

``` git
git checkout main
git branch -D new-feature-name
```