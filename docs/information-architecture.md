# inxys Information Architecture

## Roles & Privileges

Access to all information in the model is governed by privileges. Each object in the information model has a set of access privileges governing access rights to that object.

A role is a combination of privileges.

All objects in the system have a set of privileges that govern access. Users are assigned roles.

## Object model

All objects in the system have a root attribute set:
+ object id
+ owner
+ creation date
+ last editor
+ last edit date
+ access privileges

## Users

The basic entity representing a user of the system. User can represent a real person, a pseudo-preson, or a bot.

## Groups

A group is a collection of users.

## Conference

A conference is a collection of members (users and/or groups) and comments. Comments are ordered chronologically.

TOC

## Comments & Replies

A comment belongs to a single conference, is authored by a single user, and has a collection of replies.

## Notebooks

Notebooks are very similar to conferences. A notebook is a collection of members (users and/or groups) and pages. However, a notebook's pages are ordered by page number.

TOC

## Lists

Collections of objects can be gathered together into a list.

## Notifications

Notifications of events that occur within the system are sent to users and groups and managed in a notification queue.

## Chat

Realtime messaging.

 - user to user
 - collection of users
 - group
 - conference members

Chat history

## Misc

What was the editing and change modification concepts, tracking changes?

## Interact

An Interact programming language (should we just use JavaScript?)
{% expression %}

## Editor

An editor allows a user to compose in a scratchpad. Compositions can be set aside and completed at a later time.
