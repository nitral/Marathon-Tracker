Marathon Tracker
================

**A Tracker and Registration Software for Marathon Events.**

About
-----
A Marathon is a test of not only physical fitness but also physical as well as mental endurance. Hence, marathons become the center of any Sports Fest or Meet. Using this software, comprehensive **registrations** can be done via a terminal on-the-spot easily.

To become a better racer, one needs to critially analyze their performance. For this, data needs to be taken. By having terminals running the **tracker** part of this software on each checkpoint, it is possible to obtain such data. Data analysis will yield the statistics needed by the racer to improve.

Installation
------------
**Open web standards** were used in making this software. An installed *LAMP* stack will be needed along with a database to run *SQL* queries on. This Web Application must be put online on a **central server**. All checkpoints need to at least once use the internet to open the web application. Thereafter, work can be **done offline**, if needed.

Working
-------
Each checkpoint will have an checkpoint ID starting from **1**. Checkpoints need to login using the login credentials issued by the control center. On login, the Race Grid View will be activated automatically on receiving the *Start Signal* from the server.

On spotting a racer, the corresponding Bib Number button needs to be pressed. Everything is logged on the server. In case of net disruption, everything is stored locally.
On recognizing a working net connection, everything is synced back again.

Additional override commands are available which will forcefully Sync Up or Down. A Race State Printer is available which will print a JSON object of the current state of the race.

Other than this, some _**easter egg**_ commands are also available to override states of all racers in one-go.

Notes
-----
This software was used during **BITS BOSM Marathon 2014** to track and register racers.
I would love to hear how this software benefitted your marathon event.

If you wish to contribute, feel free to **fork** and send me a **pull request**!

In case you find a nasty bug, drop me an **email**.
