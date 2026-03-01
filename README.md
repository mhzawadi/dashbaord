# Horwood PHP Dashbaord

My take on a homelab dashboard, this will hook into docker and docker swarm.
With Bookmarks and application links, this will be my homepage where ever I am.

This has a login system to allow logged in users see things that should not be visible the public,
this uses both password or oauth.

## Docker labels

- dashboard.name: The name of the container
- dashboard.description: what the container does
- dashboard.icon: what icon should be used
- dashboard.https: is this over https (bool)
- dashboard.url: the full url of the service
