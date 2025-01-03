Skink Works
===========

This is a repository for the Skink project.

Design Principles
=================

- Document based
- Documents are immutable
- Documents are assembled from individual contributions
- Individual contributions are signed
- Individual contributions are stored in each contributor's data store

Use Cases
=========

- Checklists
- Picnic planning
- Choosing a movie
- Classic board game (e.g., chess)

Hosting Options
===============

- git
	- A single repo
	- Multiple repos (each contributor's own)
- Blog
- Comments section (of Bugzilla, JIRA, WordPress, etc.)

PHP Implementation Notes
========================

How to start a local PHP server

This works currently:

    php -S localhost:8080 serve/router.php

More generally:

    php -S localhost:8080 -t foo/

See https://www.php.net/manual/en/features.commandline.webserver.php

End
===

That's it for now.
