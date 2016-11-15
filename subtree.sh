git remote add deployment ssh://git@openlab.ncl.ac.uk:17150/edjenkins/xmovement-deployments.git
git subtree add --prefix=packages/deployment/ deployment library
git subtree pull --prefix=packages/deployment/ deployment library
