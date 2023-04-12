v0.0.1 (Alpha)

- basic list of applications
- basic list of bookmarks and categorys
- add applications
- edit applications
- delete applications
- add categories and bookmarks
- edit categories and bookmarks
- delete categories and bookmarks
- the start of a login system (not sure its secure)
- import Flame SQLite DB to recover apps, categories and bookmarks
- scan Docker for apps to display, using lables
  - works with both docker host and docker swarm
  - looks for `traefik.http.routers` or `dashboard.url`
  - looks for `dashboard.name`
  - looks for `dashboard.description`
  - looks for `traefik.enable` to exclude them from the scan

v0.0.2 (Alpha)

- fix getting docker URLs from traefik labels
- upload images and use them
- switch out MDI icons for an image if you uploaded it
- fix up display of MDI icons to make the editing show just the icon name
